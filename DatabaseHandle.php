<?php

class DatabaseHandle {
    const username = '<university oracle db username>';
    const password = '<university oracle db password>';
    const con_string = '<university oracle db url>';

    protected $connection;

    public function __construct() {
        try {
            $this->connection = oci_connect(
                DatabaseHandle::username,
                DatabaseHandle::password,
                DatabaseHandle::con_string
            );
            if (!$this->connection) {
                die("Failed to establish connection. No further information.");
            }
        } catch (Exception $e) {
            die("Failed to establish connection. $e");
        }
    }

    public function __destruct() {
        oci_close($this->connection);
    }

    private static function param_given($param) {
        return isset($param) && $param != '';
    }

    private static function array_concat($array, $value) {
        $result = $array;
        $result[] = $value;
        return $result;
    }

    private static function param_to_sql($param) {
        if (isset($param)) {
            return is_string($param) ? "'$param'" : "$param";
        } else {
            return 'NULL';
        }
    }

    private static function sql_equal($name, $value) {
        $sql_value = self::param_to_sql($value);
        return "$name = $sql_value";
    }

    private function executeSQL($sql) {
        $res = array();
        $statement = oci_parse($this->connection, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    private function executeDML($dml) {
        $statement = oci_parse($this->connection, $dml);
        $success = oci_execute($statement) && oci_commit($this->connection);
        oci_free_statement($statement);
        return $success;
    }

    private function runProcedure($proc, $params, $result_param_name) {
        $result = null;
        $statement = oci_parse($this->connection, $proc);

        foreach (array_keys($params) as $name) {
            oci_bind_by_name($statement, ":$name", $params[$name]);
        }
        oci_bind_by_name($statement, ":$result_param_name", $result);

        oci_execute($statement);
        oci_free_statement($statement);
        return $result;
    }

    private function buildAndExecuteSQL($table_name, $condition_array) {
        $filtered_array = array_filter($condition_array);
        $sql = "SELECT * FROM $table_name" . (
            $filtered_array
                ? ' WHERE ' . implode(' AND ', $filtered_array)
                : ''
            );
        return $this->executeSQL($sql);
    }

    private function buildAndExecuteInsert($table_name, $param_array) {
        $dmlInsert = "INSERT INTO $table_name ("
            . implode(', ', array_keys($param_array))
            . ') VALUES ('
            . implode(', ', array_map(
                function ($param) {
                    return self::param_to_sql($param);
                },
                $param_array
            ))
            . ')';
        return $this->executeDML($dmlInsert);
    }

    private function buildAndExecuteUpdate($table_name, $pk_param_array, $update_param_array) {
        $filtered_update_param_array = array_filter($update_param_array);
        $dmlUpdate = "UPDATE $table_name SET "
            . implode(', ', array_map(
                function ($name, $value) {
                    return self::sql_equal($name, $value);
                },
                array_keys($filtered_update_param_array),
                array_values($filtered_update_param_array)
            ))
            . " WHERE "
            . implode(' AND ', array_map(
                function ($name, $value) {
                    return self::sql_equal($name, $value);
                },
                array_keys($pk_param_array),
                array_values($pk_param_array)
            ));
        return $this->executeDML($dmlUpdate);
    }

    private function buildAndExecuteDelete($table_name, $pk_param_array) {
        $dmlDelete = "DELETE FROM $table_name WHERE "
            . implode(' AND ', array_map(
                function ($name, $value) {
                    return self::sql_equal($name, $value);
                },
                array_keys($pk_param_array),
                array_values($pk_param_array)
            ));
        return $this->executeDML($dmlDelete);
    }

    private function buildAndRunProcedure($procedure_name, $in_param_array, $out_param_name) {
        $proc = "BEGIN $procedure_name("
            . implode(', ', array_map(
                function ($name) {
                    return ":$name";
                },
                self::array_concat(array_keys($in_param_array), $out_param_name)))
            . '); END;';
        return $this->runProcedure($proc, $in_param_array, $out_param_name);
    }

    public function selectClient(
        $client_id,
        $full_name,
        $display_name,
        $vouchers_min,
        $vouchers_max,
        $invited_by_id
    ) {
        $conditions = array(
            self::param_given($client_id) ? "CLIENT_ID = $client_id" : null,
            self::param_given($full_name) ? "UPPER(FULL_NAME) LIKE UPPER('%$full_name%')" : null,
            self::param_given($display_name) ? "UPPER(DISPLAY_NAME) LIKE UPPER('%$display_name%')" : null,
            self::param_given($vouchers_min) ? "VOUCHERS >= $vouchers_min" : null,
            self::param_given($vouchers_max) ? "VOUCHERS <= $vouchers_max" : null,
            self::param_given($invited_by_id) ? "INVITED_BY = $invited_by_id" : null
        );

        return $this->buildAndExecuteSQL('CLIENT', $conditions);
    }

    public function insertClient(
        $full_name,
        $display_name,
        $vouchers,
        $invited_by_id
    ) {
        $in_params = array(
            'PARAM_FULL_NAME' => $full_name,
            'PARAM_DISPLAY_NAME' => $display_name,
            'PARAM_VOUCHERS' => intval($vouchers),
            'PARAM_INVITED_BY' => self::param_given($invited_by_id) ? intval($invited_by_id) : null
        );
        return $this->buildAndRunProcedure('INSERT_CLIENT', $in_params, 'RESULT_CLIENT_ID');
    }

    public function updateClient(
        $client_id,
        $full_name,
        $display_name,
        $vouchers,
        $invited_by_id
    ) {
        $pk = array(
            'CLIENT_ID' => intval($client_id)
        );
        $updated_columns = array(
            'FULL_NAME' => self::param_given($full_name) ? $full_name : null,
            'DISPLAY_NAME' => self::param_given($display_name) ? $display_name : null,
            'VOUCHERS' => self::param_given($vouchers) ? intval($vouchers) : null,
            'INVITED_BY' => self::param_given($invited_by_id) ? intval($invited_by_id) : null
        );
        return $this->buildAndExecuteUpdate('CLIENT', $pk, $updated_columns);
    }

    public function deleteClient(
        $client_id
    ) {
        $pk = array(
            'CLIENT_ID' => intval($client_id)
        );
        return $this->buildAndExecuteDelete('CLIENT', $pk);
    }

    public static function orderStatusStringToInt($status) {
        if (strtoupper($status) == 'ORDER_RECEIVED') {
            return 0;
        } else if (strtoupper($status) == 'ORDER_ACCEPTED') {
            return 1;
        } else if (strtoupper($status) == 'ACQUIRING_PARTS') {
            return 2;
        } else if (strtoupper($status) == 'PARTS_IN_SHIPMENT') {
            return 3;
        } else if (strtoupper($status) == 'IN_ASSEMBLY') {
            return 4;
        } else if (strtoupper($status) == 'PREPARING_FOR_SHIPMENT') {
            return 5;
        } else if (strtoupper($status) == 'SHIPPING') {
            return 6;
        } else if (strtoupper($status) == 'RECEIVED_BY_CUSTOMER') {
            return 7;
        } else {
            return -1;
        }
    }

    public static function orderStatusIntToString($status) {
        switch ($status) {
            case 0:
                return 'ORDER_RECEIVED';
            case 1:
                return 'ORDER_ACCEPTED';
            case 2:
                return 'ACQUIRING_PARTS';
            case 3:
                return 'PARTS_IN_SHIPMENT';
            case 4:
                return 'IN_ASSEMBLY';
            case 5:
                return 'PREPARING_FOR_SHIPMENT';
            case 6:
                return 'SHIPPING';
            case 7:
                return 'RECEIVED_BY_CUSTOMER';
            default:
                return '<unknown status>';
        }
    }

    public function selectClientOrder(
        $tracking_number,
        $status,
        $target_address,
        $price_min,
        $price_max,
        $ordered_by_id
    ) {
        $price_min_cents = $price_min ? floatval($price_min) * 100 : null;
        $price_max_cents = $price_max ? floatval($price_max) * 100 : null;
        $conditions = array(
            self::param_given($tracking_number) ? "TRACKING_NUMBER = $tracking_number" : null,
            self::param_given($status) ? ('STATUS = ' . self::orderStatusStringToInt($status)) : null,
            self::param_given($target_address) ? "UPPER(TARGET_ADDRESS) LIKE UPPER('%$target_address%')" : null,
            self::param_given($price_min) ? "PRICE >= $price_min_cents" : null,
            self::param_given($price_max) ? "PRICE <= $price_max_cents" : null,
            self::param_given($ordered_by_id) ? "INVITED_BY = $ordered_by_id" : null
        );

        return $this->buildAndExecuteSQL('CLIENT_ORDER', $conditions);
    }

    public function insertClientOrder(
        $status,
        $target_address,
        $price,
        $admission_date,
        $ordered_by_id
    ) {
        $in_params = array(
            'PARAM_STATUS' => self::orderStatusStringToInt($status),
            'PARAM_TARGET_ADDRESS' => $target_address,
            'PARAM_PRICE' => intval(floatval($price) * 100),
            'PARAM_ADMISSION_DATE' => $admission_date,
            'PARAM_ORDERED_BY' => $ordered_by_id
        );
        return $this->buildAndRunProcedure('INSERT_CLIENT_ORDER', $in_params, 'RESULT_TRACKING_NUMBER');
    }

    public function updateClientOrder(
        $tracking_number,
        $status,
        $target_address,
        $price,
        $ordered_by_id
    ) {
        $pk = array(
            'TRACKING_NUMBER' => intval($tracking_number)
        );
        $updated_columns = array(
            'STATUS' => self::param_given($status) ? self::orderStatusStringToInt($status) : null,
            'TARGET_ADDRESS' => self::param_given($target_address) ? $target_address : null,
            'PRICE' => self::param_given($price) ? intval(floatval($price) * 100) : null,
            'ORDERED_BY_ID' => self::param_given($ordered_by_id) ? intval($ordered_by_id) : null
        );
        return $this->buildAndExecuteUpdate('CLIENT_ORDER', $pk, $updated_columns);
    }

    public function deleteClientOrder(
        $tracking_number
    ) {
        $pk = array(
            'TRACKING_NUMBER' => intval($tracking_number)
        );
        return $this->buildAndExecuteDelete('CLIENT_ORDER', $pk);
    }

    public function selectBuild(
        $tracking_number,
        $build_id,
        $price_min,
        $price_max,
        $performance_rating
    ) {
        $price_min_cents = $price_min ? floatval($price_min) * 100 : null;
        $price_max_cents = $price_max ? floatval($price_max) * 100 : null;
        $conditions = array(
            self::param_given($tracking_number) ? "TRACKING_NUMBER = $tracking_number" : null,
            self::param_given($build_id) ? "BUILD_ID = '$build_id'" : null,
            self::param_given($price_min) ? "PRICE >= $price_min_cents" : null,
            self::param_given($price_max) ? "PRICE <= $price_max_cents" : null,
            self::param_given($performance_rating) ? (strtoupper($performance_rating) == 'NULL'
                ? 'PERFORMANCE_RATING IS NULL'
                : "PERFORMANCE_RATING = $performance_rating"
            ) : null
        );
        return $this->buildAndExecuteSQL('BUILD', $conditions);
    }

    public function insertBuild(
        $tracking_number,
        $build_id,
        $price,
        $performance_rating
    ) {
        $params = array(
            'TRACKING_NUMBER' => intval($tracking_number),
            'BUILD_ID' => $build_id,
            'PRICE' => intval(floatval($price) * 100),
            'PERFORMANCE_RATING' => self::param_given($performance_rating) ? floatval($performance_rating) : null
        );
        return $this->buildAndExecuteInsert('BUILD', $params);
    }

    public function updateBuild(
        $tracking_number,
        $build_id,
        $price,
        $performance_rating
    ) {
        $pk = array(
            'TRACKING_NUMBER' => intval($tracking_number),
            'BUILD_ID' => $build_id
        );
        $updated_columns = array(
            'PRICE' => self::param_given($price) ? intval(floatval($price) * 100) : null,
            'PERFORMANCE_RATING' => self::param_given($performance_rating) ? (strtoupper($performance_rating) == 'NULL'
                ? $performance_rating
                : floatval($performance_rating)
            ) : null,
        );
        return $this->buildAndExecuteUpdate('BUILD', $pk, $updated_columns);
    }

    public function deleteBuild(
        $tracking_number,
        $build_id
    ) {
        $pk = array(
            'TRACKING_NUMBER' => intval($tracking_number),
            'BUILD_ID' => $build_id
        );
        return $this->buildAndExecuteDelete('BUILD', $pk);
    }

    public function selectVendor(
        $vendor_id,
        $name,
        $homepage
    ) {
        $conditions = array(
            self::param_given($vendor_id) ? "VENDOR_ID = $vendor_id" : null,
            self::param_given($name) ? "UPPER(NAME) LIKE UPPER('%$name%')" : null,
            self::param_given($homepage) ? (strtoupper($homepage) == 'NULL'
                ? "HOMEPAGE IS NULL"
                : "UPPER(HOMEPAGE) LIKE UPPER('%$homepage%')"
            ) : null
        );
        return $this->buildAndExecuteSQL('VENDOR', $conditions);
    }

    public function insertVendor(
        $vendor_id,
        $name,
        $homepage
    ) {
        $params = array(
            'VENDOR_ID' => $vendor_id,
            'NAME' => $name,
            'HOMEPAGE' => $homepage
        );
        return $this->buildAndExecuteInsert('VENDOR', $params);
    }

    public function updateVendor(
        $vendor_id,
        $name,
        $homepage
    ) {
        $pk = array(
            'VENDOR_ID' => $vendor_id
        );
        $updated_columns = array(
            'NAME' => $name,
            'HOMEPAGE' => self::param_given($homepage) ? $homepage : null
        );
        return $this->buildAndExecuteUpdate('VENDOR', $pk, $updated_columns);
    }

    public function deleteVendor(
        $vendor_id
    ) {
        $pk = array(
            'VENDOR_ID' => $vendor_id
        );
        return $this->buildAndExecuteDelete('VENDOR', $pk);
    }

    public function selectManufacturer(
        $manufacturer_id,
        $name,
        $homepage
    ) {
        $conditions = array(
            self::param_given($manufacturer_id) ? "VENDOR_ID = $manufacturer_id" : null,
            self::param_given($name) ? "UPPER(NAME) LIKE UPPER('%$name%')" : null,
            self::param_given($homepage) ? (strtoupper($homepage) == 'NULL'
                ? "HOMEPAGE IS NULL"
                : "UPPER(HOMEPAGE) LIKE UPPER('%$homepage%')"
            ) : null
        );
        return $this->buildAndExecuteSQL('MANUFACTURER', $conditions);
    }

    public function insertManufacturer(
        $manufacturer_id,
        $name,
        $homepage
    ) {
        $params = array(
            'MANUFACTURER_ID' => $manufacturer_id,
            'NAME' => $name,
            'HOMEPAGE' => $homepage
        );
        return $this->buildAndExecuteInsert('MANUFACTURER', $params);
    }

    public function updateManufacturer(
        $manufacturer_id,
        $name,
        $homepage
    ) {
        $pk = array(
            'MANUFACTURER_ID' => $manufacturer_id
        );
        $updated_columns = array(
            'NAME' => $name,
            'HOMEPAGE' => self::param_given($homepage) ? $homepage : null
        );
        return $this->buildAndExecuteUpdate('MANUFACTURER', $pk, $updated_columns);
    }

    public function deleteManufacturer(
        $manufacturer_id
    ) {
        $pk = array(
            'MANUFACTURER_ID' => $manufacturer_id
        );
        return $this->buildAndExecuteDelete('MANUFACTURER', $pk);
    }
}