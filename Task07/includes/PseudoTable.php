<?php
function draw_table($table) {

    $columns_count = count( $table[0] )/2;
    $max_column_length = array( $columns_count );
    $columns_names = array( $columns_count );
    $table_width = 0;

    for ($i = 0; $i < $columns_count*2; $i += 2){
        $columns_names[$i/2] = array_keys($table[0])[$i];
        $max_column_length[$i/2] = iconv_strlen(array_keys($table[0])[$i]);
    }


    foreach ($table as $row) 
        for ($i=0; $i<$columns_count; $i++) 
            if (iconv_strlen($row[$i]) > $max_column_length[$i]) 
                        $max_column_length[$i] = iconv_strlen($row[$i]);


    for ($i = 0; $i < $columns_count; $i++)
        $table_width += $max_column_length[$i] + 2;
    

    empty_line($columns_count, $max_column_length, 1);
    line_with_data($columns_count, $max_column_length, $columns_names);
    empty_line($columns_count, $max_column_length, 2);

    for ($i = 0; $i < count($table); $i++)
        line_with_data($columns_count, $max_column_length, $table[$i]);
    

    empty_line($columns_count, $max_column_length, 3);

}

function empty_line($columns_count, $max_column_length, $mode){
    $middle_sep = '';
    $start_sep = '';
    $end_sep = '';

    switch ($mode){
        case 1:
            $middle_sep = "┬";
            $start_sep = '┌';
            $end_sep = '┐';
            break;

        case 2:
            $middle_sep = "┼";
            $start_sep = '├';
            $end_sep = '┤';
            break;

        case 3:
            $middle_sep = "┴";
            $start_sep = '└';
            $end_sep = '┘';
            break;
    }

    print_r($start_sep);
    for ($i = 0; $i < $columns_count; $i++){
        if ($i != $columns_count-1)
            print_r(str_repeat('─', $max_column_length[$i]+2) . $middle_sep );
        else
        print_r(str_repeat('─', $max_column_length[$i]+2) . $end_sep );
    }
    print_r("\n");
}

function line_with_data($columns_count, $max_column_length, $data){
    print_r("│");

    for ($i = 0; $i < $columns_count; $i++){
        $space_count = $max_column_length[$i]+1 - iconv_strlen($data[$i]);
        print_r(" " . $data[$i] . str_repeat(' ', $space_count) . "│");
    }
    print_r("\n");
}
?>