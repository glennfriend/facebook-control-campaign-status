<?php

/**
 *  cc ccHelper function call
 *
 *  example:
 *      cc('date',   time()       );
 *      cc('escape', $articleText );
 *
 *  @param helper function name
 *  @param param2
 *  @param param3
 *  @param param4
 *  @param param5
 *  @return maybe have maybe not have
 */
function cc()
{
    $numArgs = func_num_args();
    $args    = func_get_args();
    $func    = $args[0];

    $functionFile = dirname(__DIR__) . '/ccHelper/' . $func . '.php';
    if (!file_exists($functionFile)) {
        throw new Exception('Error: cc helper "'. $func .'" function not fount!');
    }
    include_once ($functionFile);

    $name = 'ccHelper_'. $func;

    switch( $numArgs )
    {
        case 1: return $name();                                         exit;
        case 2: return $name( $args[1] );                               exit;
        case 3: return $name( $args[1], $args[2] );                     exit;
        case 4: return $name( $args[1], $args[2], $args[3]);            exit;
        case 5: return $name( $args[1], $args[2], $args[3], $args[4] ); exit;
        default:
            throw new Exception('Error: cc helper arguments to much');
    }
}
