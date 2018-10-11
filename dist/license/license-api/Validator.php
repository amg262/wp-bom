<?php

namespace Devtech\License;

/**
 * Description of Validator
 *
 * @author jpuchky
 */
class Validator {
    public function validate(License $license,$key) {
        $generator = new Generator();
        $newKey = $generator->generate($license);
        if($key === $newKey) {
            return true;
        } else {
            return false;
        }
    }
}
