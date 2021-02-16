<?php

namespace Nrg\Utility;

trait PopulateProps
{
    public function populateProps(array $props, array $exceptProps = []): void
    {
        foreach ($props as $prop => $value) {
            if (in_array($prop, $exceptProps)) {
                continue;
            }

            $setter = 'set'.ucfirst($prop);

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
    }
}
