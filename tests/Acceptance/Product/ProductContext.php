<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Product;

use Behat\Behat\Context\Context;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ProductContext implements Context
{
    private string $endpoint;
    private array $credentials;
    private string|bool $response;
    private string $error;
    private int $httpCode;

    /**
     * @Given the api url :endpoint
     */
    public function userCredentials(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @When make the request
     */
    public function makeCreateUser(): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://app.nginx' . $this->endpoint);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $this->response = curl_exec($ch);
        $this->error = curl_error($ch);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    /**
     * @Then should return the products
     */
    public function theUserHasBeenCreated(): void
    {
        if (false === $this->response || $this->httpCode !== 200) {
            $message = $this->error ?: $this->response;
            throw new \RuntimeException($message);
        }


        $data = json_decode($this->response, true);
        $products = $data['products'];
        $currentFields = array_keys($products[0]);
        $expectedFields = ['sku', 'name', 'category', 'price'];

        if ($currentFields !== $expectedFields) {
            throw new \RuntimeException(
                sprintf(
                    'Expected fields response not returned. Expected: %s, Current: %s',
                    implode(',', $expectedFields),
                    implode(',', $currentFields)
                )
            );
        }

        $currentPriceFields = array_keys($products[0]['price']);
        $expectedPriceFields = ['original', 'final', 'discount_percentatge', 'currency'];

        if ($currentPriceFields !== $expectedPriceFields) {
            throw new \RuntimeException(
                sprintf(
                    'Expected price fields response not returned. Expected: %s, Current: %s',
                    implode(',', $currentPriceFields),
                    implode(',', $expectedPriceFields)
                )
            );
        }
    }
}
