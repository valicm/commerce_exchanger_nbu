<?php

namespace Drupal\commerce_exchanger_nbu\Plugin\Commerce\ExchangerProvider;

use Drupal\commerce_exchanger\Plugin\Commerce\ExchangerProvider\ExchangerProviderRemoteBase;
use Drupal\Component\Serialization\Json;


/**
 * Provides the National Bank of Ukraine exchange rates.
 *
 * @CommerceExchangerProvider(
 *   id = "nbu",
 *   label = "National Bank of Ukraine",
 *   display_label = "National Bank of Ukraine",
 *   historical_rates = TRUE,
 *   base_currency = "UAH",
 *   refresh_once = TRUE,
 *   transform_rates=TRUE,
 * )
 */
class NbuExchanger extends ExchangerProviderRemoteBase {

  /**
   * {@inheritdoc}
   */
  public function apiUrl() {
    return 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
  }

  /**
   * {@inheritdoc}
   */
  public function getRemoteData($base_currency = NULL) {
    $data = NULL;

    $request = $this->apiClient([]);

    if ($request) {
      $exchanges = Json::decode($request);
      foreach ($exchanges as $exchange) {
        $data[$exchange['cc']] = $exchange['rate'];
      }
    }

    return $data;
  }

}
