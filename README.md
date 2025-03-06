# ItemSetSearch Module for Omeka S

## Overview
The ItemSetSearch module enhances Omeka S with customizable search block layouts that can be added to any site page. This module provides flexible searching capabilities with options for filtering by item sets, properties, and multiple search fields with configurable search conditions.

## Features
### Multiple Search Block Layouts:
- **Item Set Search**: Search within specific item sets with customizable properties.
- **School Name Search**: Dual field search specifically designed for searching school information.
- **Dual Field Combobox Search**: Search using two dropdown fields with predefined values.
- **Item Set Specific Single Field**: Search within a specific item set using a single property field.

### Configurable Search Options:
- Search conditions: "Contains", "Exact match", or "Starts with".
- Join conditions: "AND" or "OR" between search fields.
- Customizable placeholder text for improved accessibility.
- Ability to select which metadata properties to search against.

## Installation
1. Download the module from the GitHub repository.
2. Extract the ZIP file to your Omeka S `/modules` directory.
3. Rename the directory to `ItemSetSearch`.
4. Log in to your Omeka S admin interface and navigate to **Modules**.
5. Click **Install** next to the ItemSetSearch module.

## Usage
### Adding Search Blocks to Site Pages
1. Edit a site page or create a new one.
2. Click **Add New Block**.
3. Select one of the ItemSetSearch block layouts:
   - "Item Set Search | Customizable | Empowered"
   - "School Name Search | Customizable | Empowered"
   - "Empowered | Dual Combobox | Search"
   - "Empowered | Item Set Specific | Single Field"

### Configuring Search Blocks
#### Item Set Search
- Option to include a blank option in the item set dropdown.
- Select the property to search against.
- Set placeholder text for the search field.
- Choose join condition and search type.

#### School Name Search
- Configure two property fields to search against.
- Set placeholder text for both fields.
- Choose join condition between fields (AND/OR).
- Configure search conditions for each field.

#### Dual Field Combobox Search
- Configure two property fields with dropdown selections.
- Values for dropdowns are automatically populated from existing metadata.
- Set join condition between fields.
- Configure search type for each field.

#### Item Set Specific Search
- Select a specific item set to restrict the search to.
- Configure a single property to search against.
- Set placeholder text for the search field.

## Block Types and Their Uses
| Block Type | Best Used For |
|------------|-------------------------------|
| Item Set Search | Collections where users need to browse within specific item sets. |
| School Name Search | Educational collections where searching by multiple school-related fields is needed. |
| Dual Field Combobox Search | When users should select from predefined values rather than free text input. |
| Item Set Specific | When a search should always be restricted to a specific collection. |

## Template Files
The module includes the following template files for rendering the search blocks:
- `common/block-layout/empowered-custom-item-set`
- `common/block-layout/empowered-custom-school-name`
- `common/block-layout/empowered-dualfieldcombobox`
- `common/block-layout/empowered-itemsetspecific`

## Requirements
- Omeka S

## License
This module is licensed under the **GNU General Public License v3.0**.
See the [LICENSE](LICENSE) file for more details.


