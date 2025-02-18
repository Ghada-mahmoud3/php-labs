<?php
include_once('config.php');

// Insert data into a table
function insertData($table, $columns, $values) {
    $db = getDB();
    $columnsStr = implode(',', $columns);
    $placeholders = implode(',', array_fill(0, count($values), '?'));
    
    $sql = "INSERT INTO $table ($columnsStr) VALUES ($placeholders)";
    $stmt = $db->prepare($sql);
    $stmt->execute($values);

    return $db->lastInsertId();  // Return the ID of the inserted record
}

// Select data from a table
function selectData($table, $columns = "*", $conditions = []) {
    $db = getDB();
    $columnsStr = is_array($columns) ? implode(',', $columns) : $columns;
    $sql = "SELECT $columnsStr FROM $table";
    
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", array_map(fn($col) => "$col = ?", array_keys($conditions)));
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute(array_values($conditions));
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update data in a table
function updateData($table, $data, $where) {
    $db = getDB();
    $setPart = implode(" = ?, ", array_keys($data)) . " = ?";
    $wherePart = implode(" = ? AND ", array_keys($where)) . " = ?";
    
    $sql = "UPDATE $table SET $setPart WHERE $wherePart";
    $stmt = $db->prepare($sql);
    $stmt->execute(array_merge(array_values($data), array_values($where)));
    
    return $stmt->rowCount();
}

// Delete data from a table
function deleteData($table, $where) {
    $db = getDB();
    $wherePart = implode(" = ? AND ", array_keys($where)) . " = ?";
    
    $sql = "DELETE FROM $table WHERE $wherePart";
    $stmt = $db->prepare($sql);
    $stmt->execute(array_values($where));
    
    return $stmt->rowCount();
}
?>
