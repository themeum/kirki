<?php
/**
 * Class aliases for backwards-compatibility.
 *
 * @package    Kirki
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      4.0
 */

class_alias( 'Kirki\Modules\Custom_Sections\Module', 'Kirki_Modules_Custom_Sections' );
add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Modules\Custom_Sections\Section_Default', 'Kirki_Sections_Default_Section' );
        class_alias( 'Kirki\Modules\Custom_Sections\Section_Expanded', 'Kirki_Sections_Expanded_Section' );
        class_alias( 'Kirki\Modules\Custom_Sections\Section_Nested', 'Kirki_Sections_Nested_Section' );
        class_alias( 'Kirki\Modules\Custom_Sections\Section_Link', 'Kirki_Sections_Link_Section' );
        class_alias( 'Kirki\Modules\Custom_Panels\Panel_Nested', 'Kirki_Panels_Nested_Panel' );
    }
);

