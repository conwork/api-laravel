<?php
use Dedoc\Scramble\Scramble;

if (!app()->environment('production')) {
    Scramble::registerUiRoute('docs');
    Scramble::registerJsonSpecificationRoute('docs.json');
}
