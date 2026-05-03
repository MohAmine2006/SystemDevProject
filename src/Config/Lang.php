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

            // Daily sales section (reports page)
            'sales_section'      => 'Daily Sales',
            'no_sales'           => 'No sales recorded for this date.',
            'col_qty_sold'       => 'Qty Sold',
            'col_sale_price'     => 'Sale Price',
            'col_line_total'     => 'Total',
            'col_qty_remaining'  => 'Qty Left',
            'col_staff'          => 'Staff',
            'daily_revenue'      => 'Total Revenue',
            'daily_units'        => 'Units Sold',
            'stock_levels'       => 'End-of-Day Stock Levels',

            // User manual
            'manual_title'           => 'User Manual',
            'manual_employee_tab'    => 'Employee',
            'manual_owner_tab'       => 'Owner',
            'manual_emp_h'           => 'Employee Guide',
            'manual_emp_1_h'         => 'Logging In',
            'manual_emp_1_b'         => 'Enter your username and password, select Employee, then click Sign In.',
            'manual_emp_2_h'         => 'Viewing Inventory',
            'manual_emp_2_b'         => 'The inventory table shows all products — their category, quantity, price, daily profit and stock status.',
            'manual_emp_3_h'         => 'Searching & Filtering',
            'manual_emp_3_b'         => 'Use the search bar to find a product by name, or use the category dropdown to filter by type.',
            'manual_emp_4_h'         => 'Editing a Product',
            'manual_emp_4_b'         => 'Click the pencil icon (✏) on any row to open the edit form. Update the fields and click Save Changes.',
            'manual_emp_5_h'         => 'Recording a Sale',
            'manual_emp_5_b'         => 'When you reduce a product\'s quantity and save, a sale is automatically recorded for the difference.',
            'manual_emp_6_h'         => 'Changing Language',
            'manual_emp_6_b'         => 'Click the FR / EN button in the top-right corner to switch between English and French.',
            'manual_own_h'           => 'Owner Guide',
            'manual_own_intro'       => 'Owners have all Employee permissions, plus:',
            'manual_own_1_h'         => 'Adding a Product',
            'manual_own_1_b'         => 'Click the green "+ Add Item" button, fill in the form, and click Add Item.',
            'manual_own_2_h'         => 'Deleting a Product',
            'manual_own_2_b'         => 'Click the red trash icon (🗑) on any row. Confirm the deletion in the pop-up dialog.',
            'manual_own_3_h'         => 'Inventory Value Card',
            'manual_own_3_b'         => 'The extra stats card on the dashboard shows the total monetary value of all current stock.',
            'manual_own_4_h'         => 'Generating a Report',
            'manual_own_4_b'         => 'Go to the Reports tab, pick a date, review the preview (daily sales + stock levels), then click Generate PDF Report to download.',
            'manual_own_5_h'         => 'Reading the PDF Report',
            'manual_own_5_b'         => 'The PDF contains: an inventory summary, a daily sales breakdown (products sold, quantities, revenue), and end-of-day stock levels for every product.',
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

            // Daily sales section
            'sales_section'      => 'Ventes du jour',
            'no_sales'           => 'Aucune vente enregistrée pour cette date.',
            'col_qty_sold'       => 'Qté vendue',
            'col_sale_price'     => 'Prix de vente',
            'col_line_total'     => 'Total',
            'col_qty_remaining'  => 'Qté restante',
            'col_staff'          => 'Personnel',
            'daily_revenue'      => 'Revenu total',
            'daily_units'        => 'Unités vendues',
            'stock_levels'       => 'Niveaux de stock en fin de journée',

            // User manual
            'manual_title'           => "Manuel d'utilisation",
            'manual_employee_tab'    => 'Employé',
            'manual_owner_tab'       => 'Propriétaire',
            'manual_emp_h'           => "Guide de l'employé",
            'manual_emp_1_h'         => 'Connexion',
            'manual_emp_1_b'         => "Entrez votre nom d'utilisateur et votre mot de passe, sélectionnez Employé, puis cliquez sur Se connecter.",
            'manual_emp_2_h'         => "Voir l'inventaire",
            'manual_emp_2_b'         => "Le tableau d'inventaire affiche tous les produits — leur catégorie, quantité, prix, profit quotidien et statut de stock.",
            'manual_emp_3_h'         => 'Recherche et filtres',
            'manual_emp_3_b'         => 'Utilisez la barre de recherche pour trouver un produit par nom, ou le menu déroulant de catégorie pour filtrer.',
            'manual_emp_4_h'         => 'Modifier un produit',
            'manual_emp_4_b'         => "Cliquez sur l'icône crayon (✏) sur une ligne pour ouvrir le formulaire d'édition. Mettez à jour les champs et cliquez sur Enregistrer.",
            'manual_emp_5_h'         => 'Enregistrer une vente',
            'manual_emp_5_b'         => "Lorsque vous réduisez la quantité d'un produit et sauvegardez, une vente est automatiquement enregistrée pour la différence.",
            'manual_emp_6_h'         => 'Changer de langue',
            'manual_emp_6_b'         => 'Cliquez sur le bouton FR / EN en haut à droite pour basculer entre le français et l\'anglais.',
            'manual_own_h'           => 'Guide du propriétaire',
            'manual_own_intro'       => 'Les propriétaires ont toutes les autorisations des employés, plus :',
            'manual_own_1_h'         => 'Ajouter un produit',
            'manual_own_1_b'         => 'Cliquez sur le bouton vert "+ Ajouter un article", remplissez le formulaire et cliquez sur Ajouter.',
            'manual_own_2_h'         => 'Supprimer un produit',
            'manual_own_2_b'         => "Cliquez sur l'icône poubelle rouge (🗑) sur une ligne. Confirmez la suppression dans la boîte de dialogue.",
            'manual_own_3_h'         => "Carte valeur d'inventaire",
            'manual_own_3_b'         => "La carte supplémentaire du tableau de bord affiche la valeur monétaire totale de tout le stock actuel.",
            'manual_own_4_h'         => 'Générer un rapport',
            'manual_own_4_b'         => "Allez dans l'onglet Rapports, choisissez une date, vérifiez l'aperçu (ventes du jour + niveaux de stock), puis cliquez sur Générer un rapport PDF.",
            'manual_own_5_h'         => 'Lire le rapport PDF',
            'manual_own_5_b'         => "Le PDF contient : un résumé de l'inventaire, un détail des ventes journalières (produits vendus, quantités, revenus) et les niveaux de stock en fin de journée.",
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

