<?php

namespace framework\ajax\boost;

class amp
{
    private static function isAMP( $amp_url = '' )
    {
        $isAmp = false;

        $req_url = $amp_url;

        if ( strpos($req_url, 'amp/') !== false )  {
            $isAmp = true;
        }

        return $isAmp;
    }

    public static function ampLink( $amp_host = '', $amp_url = '' )
    {
        $req_uri = '';

        if ( !filter_var( $amp_host, FILTER_SANITIZE_URL ) )
            return false;
        else
            $req_uri = $amp_host;

        $req_url = $amp_url;
        $is_amp = self::isAMP( $amp_url );


        $_pref = '/amp';

        if ( '/' !== $amp_url )
            $_pref .= '/' . $req_url;

        $req_uri .= $is_amp ? $req_url : $_pref ;

        $req_rel = $is_amp  ? 'canonical' : 'amphtml';

        return "<link rel=\"{$req_rel}\" href=\"{$req_uri}\">";
    }
}