<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/5/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like adding helpers.
     *
     * e.g. `$this->addHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Custom currency formatter to support custom codes like ZWG -> ZiG.
     *
     * @param mixed $amount The numeric amount to format.
     * @param string|null $currencyCode The ISO currency code.
     * @return string Formatted currency string.
     */
    public function formatCurrency($amount, ?string $currencyCode): string
    {
        $currencyCode = $currencyCode ? strtoupper(trim($currencyCode)) : 'USD';
        $currencySymbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'ZWG' => 'ZiG',
            'ZAR' => 'R',
            'CAD' => 'C$',
            'AUD' => 'A$',
        ];
        $symbol = $currencySymbols[$currencyCode] ?? $currencyCode;
        $space = in_array($symbol, ['$', '€', '£']) ? '' : ' ';
        return $symbol . $space . number_format((float)$amount, 2);
    }
}
