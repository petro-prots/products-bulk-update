# PetroProts Products Bulk Update extension
This extension implements products bulk attributes update by utilizing the Magento's build-in `product_action_attribute.update` queue.

## API
The extension's functionality relies on the REST API connection.
There is only one action available:

`POST V1/products/update_attributes/bulk`.
Arguments:
- `products`: List of products' attributes data to update.
  Example:
  ```json
  {
      "id": 1,
      "attribute": "name",
      "value": "New name"
  }
  ```
- `scopeData`: Data about the current working scope.
  Example:
  ```json
  {
    "store_id": 1,
    "website_id": 1,
  }
  ```

## Interfaces
There is a list of open Interfaces available for use:
- `\PetroProts\ProductsBulkUpdate\Api\UpdateProductAttributesActionInterface` - Update attribute data action. Main working part
- `\PetroProts\ProductsBulkUpdate\Api\PayloadValidatorInterface` - Payload data validator
