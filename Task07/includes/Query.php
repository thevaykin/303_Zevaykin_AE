<?php
function list_of_services_for_employee( $pdo, $id_list, $order_query=NULL){
    $id_list = implode(',', $id_list);

    $list_of_all_services_query = "
        SELECT 
            e.id AS 'Номер мастера', 
            e.last_name || ' ' || e.name || ' ' || e.second_name AS 'ФИО',
            w.work_date AS 'Дата работы',
            s.name AS 'Услуга',
            s.price AS 'Стоимость'
        FROM work_track AS w
        INNER JOIN employee AS e ON w.id_employee = e.id
        INNER JOIN service AS s ON w.id_service = s.id
        WHERE e.id IN (".$id_list.")
    ";

    $statement = $pdo->query( $list_of_all_services_query.$order_query );
    $rows = $statement->fetchAll();
    draw_table($rows);
    $statement->closeCursor();
}

function get_array_of_employee_numbers( $rows ){
    $array = array( count( $rows ) );
    for( $i = 0; $i < count( $rows ); $i++)
        $array[$i] = $rows[$i][0];
    return $array;
}
?>