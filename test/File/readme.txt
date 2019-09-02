
    use Cor\Ydin;


    echo Ydin\File\Mime::getByFile('/tmp/upload-file-00001');
        // EX. text/csv

    print_r( Ydin\File\Mime::getExtendGroup() );
        // output array

    print_r( Ydin\File\Mime::getByExtendName('csv') );
        Array
        (
            [0] => text/csv
            [1] => text/comma-separated-values
            [2] => application/csv-tab-delimited-table
            [3] => application/vnd.ms-excel
            [4] => application/octet-stream
        )
