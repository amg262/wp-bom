<?php

namespace Devtech\License;

/**
 * Description of Generator
 *
 * @author jpuchky
 */
class Generator {
    public function generate(License $license) {
        $key = md5($license);
        $key_formated = '';
        for($i=0;$i<strlen($key);$i++) {
            if($i>0 && $i % 5 == 0) {
                $key_formated .= strtoupper(substr($key, $i, 5)) . '-';
            }
        }
        
        return trim($key_formated,'-');
    }
}
