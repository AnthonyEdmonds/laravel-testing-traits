# Laravel Testing Traits

Make testing easier with this collection of testing traits!

## Installation

1. Add the library using Composer:
    ```bash
   composer require anthonyedmonds\laravel-database-log
   ```
2. The service provider will be automatically registered. If required, you can manually register the service provider by adding it to your bootstrap/providers.php:
   ```php
   return [
       ...
       AnthonyEdmonds\GovukLaravel\Providers\GovukServiceProvider::class,
       ...
   ];
   ```
3. If you are not using the standard `App\Models\User` model, publish the config file using Artisan:
   ```
   php artisan vendor:publish --provider="AnthonyEdmonds\LaravelTestingTraits\TestingTraitsServiceProvider"
   ```
   Then update the config to point to your model:
   ```php
   return [
       'user_model' => \App\Models\User::class,
   ];
   ```

## Usage

1. Add the desired traits to your `Tests\TestCase.php` class
2. Use the test methods in your tests:
   ```php
   $this->assertFormRequestPasses(...);
   $this->assertBelongsTo(...);
   ```

## Available traits

| Trait                  | Purpose                                                                     | Methods                                                                                |
|------------------------|-----------------------------------------------------------------------------|----------------------------------------------------------------------------------------|
| AssertsActivities      | Test whether a Spatie/ActivityLog has been recorded                         | assertActivity                                                                         |
| AssetsFlashMessages    | Test whether a Laracasts/Flash message has been set                         | assertFlashed                                                                          |
| AssertsFormRequests    | Test whether a FormRequest validates as expected                            | assertFormRequestPasses, assertFormRequestFails                                        |
| AssertsOrder           | Test whether a Collection is in order                                       | assertAscending, assertDescending                                                      |
| AssertsPolicies        | Test whether a Policy works as expected                                     | assertPolicyAllows, assertPolicyDenies                                                 |
| AssertsRelationships   | Test whether a Model relationship loads as expected                         | assertBelongsTo, assertBelongsToMany, assertHasMany, assertHasOne                      |
| AssertsResults         | Test whether a Collection contains the expected values                      | assertResultsMatch, assertResultsContain, assertResultsDontContain, assertResultsCount |
| AssertsValidationRules | Test whether a custom Rule works as expected                                | assertRulesPasses, assertRuleFails                                                     |
| GetsRawCsvs            | Process a raw CSV into an array for parsing                                 | processRawCsv                                                                          |
| GetsStreamedResponses  | Intercept a StreamedResponse for testing files                              | getStreamedResponse                                                                    |
| SignsInUsers           | Sign a User in with relevant Spatie/LaravelPermission Roles and Permissions | signIn, signInAs, signInWithRole, signInWithPermission                                 |
