<?php
namespace App\Config;

class Lang
{
    private static array $strings = [

        /* ================================================================
         * ENGLISH
         * ================================================================ */
        'en' => [
            // App / branding
            'app_name'            => 'La Fruiterie Global',
            'inventory_system'    => 'Inventory System',
            'lang_switch'         => 'FR',

            // Login page
            'login_subtitle'         => 'Sign in to access the inventory management system',
            'username'               => 'Username',
            'username_placeholder'   => 'Enter your username',
            'password'               => 'Password',
            'password_placeholder'   => 'Enter your password',
            'login_as'               => 'Login as',
            'role_employee'          => 'Employee',
            'role_employee_desc'     => 'View and update inventory',
            'role_owner'             => 'Owner',
            'role_owner_desc'        => 'Full access with analytics',
            'sign_in'                => 'Sign In',
            'invalid_credentials'    => 'Invalid username or password.',

            // Header
            'welcome'   => 'Welcome,',
            'logout'    => 'Logout',

            // Nav tabs
            'nav_inventory' => 'Inventory Items',
            'nav_reports'   => 'Reports',

            // Stats cards
            'stat_total_items'    => 'Total Items',
            'stat_in_stock'       => 'In stock',
            'stat_products'       => 'Products',
            'stat_product_types'  => 'Product types',
            'stat_low_stock'      => 'Low Stock Alert',
            'stat_need_reorder'   => 'Need reorder',
            'stat_overstock'      => 'Overstock Alert',
            'stat_excess'         => 'Excess inventory',
            'stat_inv_value'      => 'Inventory Value',
            'stat_total_value'    => 'Total value',

            // Inventory table section
            'inv_title'        => 'Inventory Items',
            'inv_subtitle'     => 'Manage and track your supermarket inventory',
            'btn_add_item'     => 'Add Item',
            'search_ph'        => 'Search by name or category...',
            'all_categories'   => 'All Categories',

            // Table columns
            'col_product'  => 'Product Name',
            'col_category' => 'Category',
            'col_qty'      => 'Quantity',
            'col_price'    => 'Price',
            'col_value'    => 'Value',
            'col_profit'   => 'Daily Profit',
            'col_status'   => 'Status',
            'col_actions'  => 'Actions',

            // Status badges
            'status_in_stock'    => 'In Stock',
            'status_low_stock'   => 'Low Stock',
            'status_overstocked' => 'Overstocked',

            // Modals — titles & buttons
            'modal_add_title'    => 'Add New Item',
            'modal_edit_title'   => 'Edit Item',
            'modal_delete_title' => 'Delete Item',
            'btn_save'           => 'Save Changes',
            'btn_cancel'         => 'Cancel',
            'btn_delete'         => 'Delete',
            'delete_confirm_pre'  => 'Are you sure you want to delete',
            'delete_confirm_post' => '? This action cannot be undone.',

            // Form field labels
            'field_name_en'     => 'English Name',
            'field_name_fr'     => 'French Name',
            'field_category'    => 'Category',
            'field_description' => 'Description',
            'field_quantity'    => 'Quantity',
            'field_price'       => 'Price ($)',
            'field_reorder'     => 'Reorder Level',
            'field_max_stock'   => 'Max Stock',
            'select_category'   => 'Select a category',
            'ph_name_en'        => 'e.g. Organic Apples',
            'ph_name_fr'        => 'e.g. Pommes bio',
            'ph_description'    => 'Short product description...',

            // Categories (display names — values sent to DB stay English)
            'cat_Snacks'      => 'Snacks',
            'cat_Vegetables'  => 'Vegetables',
            'cat_Fruits'      => 'Fruits',
            'cat_Dairy'       => 'Dairy',
            'cat_Meat'        => 'Meat',

            // Reports page
            'report_title'         => 'Stock Report',
            'report_subtitle'      => 'Select a date to generate a PDF report of your current inventory stock levels',
            'select_date'          => 'Select Date',
            'preview_title'        => 'Report Preview',
            'preview_date'         => 'Selected Date',
            'preview_products'     => 'Products',
            'preview_total_items'  => 'Total Items',
            'preview_total_value'  => 'Total value',
            'btn_generate_pdf'     => 'Generate PDF Report',
            'howto_title'          => 'How to Generate a Report',
            'howto_1'              => 'Select a date from the calendar above',
            'howto_2'              => 'Review the report preview to see what will be included',
            'howto_3'              => 'Click "Generate PDF Report" to download the report',
            'howto_4'              => 'The PDF will include all current inventory data with product details, quantities, prices, and stock status',

            // Flash messages
            'flash_added'   => 'Product added successfully.',
            'flash_updated' => 'Product updated successfully.',
            'flash_deleted' => 'Product deleted.',
        ],

        /* ================================================================
         * FRENCH
         * ================================================================ */
        'fr' => [
            // App / branding
            'app_name'            => 'La Fruiterie Global',
            'inventory_system'    => "Système d'inventaire",
            'lang_switch'         => 'EN',

            // Login page
            'login_subtitle'         => "Connectez-vous pour accéder au système de gestion des stocks",
            'username'               => "Nom d'utilisateur",
            'username_placeholder'   => "Entrez votre nom d'utilisateur",
            'password'               => 'Mot de passe',
            'password_placeholder'   => 'Entrez votre mot de passe',
            'login_as'               => 'Se connecter en tant que',
            'role_employee'          => 'Employé',
            'role_employee_desc'     => "Voir et mettre à jour l'inventaire",
            'role_owner'             => 'Propriétaire',
            'role_owner_desc'        => 'Accès complet avec analyses',
            'sign_in'                => 'Se connecter',
            'invalid_credentials'    => "Nom d'utilisateur ou mot de passe invalide.",

            // Header
            'welcome'   => 'Bienvenue,',
            'logout'    => 'Déconnexion',

            // Nav tabs
            'nav_inventory' => "Articles d'inventaire",
            'nav_reports'   => 'Rapports',

            // Stats cards
            'stat_total_items'    => 'Total des articles',
            'stat_in_stock'       => 'En stock',
            'stat_products'       => 'Produits',
            'stat_product_types'  => 'Types de produits',
            'stat_low_stock'      => 'Alerte stock bas',
            'stat_need_reorder'   => 'Réapprovisionnement requis',
            'stat_overstock'      => 'Alerte de surstock',
            'stat_excess'         => "Excès d'inventaire",
            'stat_inv_value'      => "Valeur de l'inventaire",
            'stat_total_value'    => 'Valeur totale',

            // Inventory table section
            'inv_title'        => "Articles d'inventaire",
            'inv_subtitle'     => 'Gérez et suivez votre inventaire de supermarché',
            'btn_add_item'     => 'Ajouter un article',
            'search_ph'        => 'Rechercher par nom ou catégorie...',
            'all_categories'   => 'Toutes les catégories',

            // Table columns
            'col_product'  => 'Nom du produit',
            'col_category' => 'Catégorie',
            'col_qty'      => 'Quantité',
            'col_price'    => 'Prix',
            'col_value'    => 'Valeur',
            'col_profit'   => 'Profit quotidien',
            'col_status'   => 'Statut',
            'col_actions'  => 'Actions',

            // Status badges
            'status_in_stock'    => 'En stock',
            'status_low_stock'   => 'Stock bas',
            'status_overstocked' => 'En surstock',

            // Modals — titles & buttons
            'modal_add_title'    => 'Ajouter un nouvel article',
            'modal_edit_title'   => "Modifier l'article",
            'modal_delete_title' => "Supprimer l'article",
            'btn_save'           => 'Enregistrer les modifications',
            'btn_cancel'         => 'Annuler',
            'btn_delete'         => 'Supprimer',
            'delete_confirm_pre'  => 'Êtes-vous sûr de vouloir supprimer',
            'delete_confirm_post' => ' ? Cette action est irréversible.',

            // Form field labels
            'field_name_en'     => 'Nom en anglais',
            'field_name_fr'     => 'Nom en français',
            'field_category'    => 'Catégorie',
            'field_description' => 'Description',
            'field_quantity'    => 'Quantité',
            'field_price'       => 'Prix ($)',
            'field_reorder'     => 'Seuil de réapprovisionnement',
            'field_max_stock'   => 'Stock maximum',
            'select_category'   => 'Sélectionnez une catégorie',
            'ph_name_en'        => 'ex. Pommes biologiques',
            'ph_name_fr'        => 'ex. Pommes bio',
            'ph_description'    => 'Courte description du produit...',

            // Categories
            'cat_Snacks'      => 'Collations',
            'cat_Vegetables'  => 'Légumes',
            'cat_Fruits'      => 'Fruits',
            'cat_Dairy'       => 'Produits laitiers',
            'cat_Meat'        => 'Viande',

            // Reports page
            'report_title'         => 'Rapport de stock',
            'report_subtitle'      => 'Sélectionnez une date pour générer un rapport PDF des niveaux de stock actuels',
            'select_date'          => 'Sélectionner une date',
            'preview_title'        => 'Aperçu du rapport',
            'preview_date'         => 'Date sélectionnée',
            'preview_products'     => 'Produits',
            'preview_total_items'  => 'Total des articles',
            'preview_total_value'  => 'Valeur totale',
            'btn_generate_pdf'     => 'Générer un rapport PDF',
            'howto_title'          => 'Comment générer un rapport',
            'howto_1'              => 'Sélectionnez une date dans le calendrier ci-dessus',
            'howto_2'              => "Vérifiez l'aperçu du rapport pour voir ce qui sera inclus",
            'howto_3'              => 'Cliquez sur "Générer un rapport PDF" pour télécharger le rapport',
            'howto_4'              => "Le PDF inclura toutes les données d'inventaire actuelles avec les détails des produits, les quantités, les prix et le statut du stock",

            // Flash messages
            'flash_added'   => 'Produit ajouté avec succès.',
            'flash_updated' => 'Produit mis à jour avec succès.',
            'flash_deleted' => 'Produit supprimé.',
        ],
    ];

    public static function get(string $key): string
    {
        $lang = $_SESSION['lang'] ?? 'en';
        return self::$strings[$lang][$key]
            ?? self::$strings['en'][$key]
            ?? $key;
    }

    public static function current(): string
    {
        return $_SESSION['lang'] ?? 'en';
    }

    /** Translate a DB category name (always stored in English). */
    public static function cat(string $dbCategory): string
    {
        return self::get('cat_' . $dbCategory);
    }
}

