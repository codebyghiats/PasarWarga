<?php

if (! function_exists('format_rupiah')) {
    /**
     * Format an integer value as Indonesian Rupiah.
     */
    function format_rupiah(int|float $value): string
    {
        return 'Rp ' . number_format((int) $value, 0, ',', '.');
    }
}
