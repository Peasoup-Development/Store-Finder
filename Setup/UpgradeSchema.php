<?php

namespace Peasoup\Storefinder\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();


        if (version_compare($context->getVersion(), '1.1.0') < 0) {
            $table = $setup->getConnection()->newTable(
            $setup->getTable('vapedirect_storefinder_images')
            )->addColumn(
                'image_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true,'auto_increment'=>true],
                'Image Id'
            )->addColumn(
                'image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Store Image'
            )->addColumn(
                'default_image',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                [],
                'Default_Image'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Store Id'
            );
            $setup->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '1.1.1') < 0) {
            //code to upgrade to 1.0.3
        }
        if (version_compare($context->getVersion(), '1.3.0') < 0) {
            $tableName = $setup->getTable('vapedirect_storefinder');
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $connection = $setup->getConnection();

                $setup->getConnection()->addColumn(
                    $setup->getTable($tableName),
                    'thursday',
                    [
                        'type' =>  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Opening Hours Thursday'
                    ]
                );

            }

        }
        if (version_compare($context->getVersion(), '1.3.1') < 0) {
            $tableName = $setup->getTable('vapedirect_storefinder');
            if ($setup->getConnection()->isTableExists($tableName) == true) {

                $setup->getConnection()->addColumn(
                    $setup->getTable($tableName),
                    'postcode',
                    [
                        'type' =>  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Store Postcode'
                    ]
                );

                $setup->getConnection()->addColumn(
                    $setup->getTable($tableName),
                    'placeId',
                    [
                        'type' =>  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Store Google Place Id'
                    ]
                );

            }

        }
        if (version_compare($context->getVersion(), '1.3.2') < 0) {
            $tableName = $setup->getTable('vapedirect_storefinder');
            if ($setup->getConnection()->isTableExists($tableName) == true) {

                $setup->getConnection()->addColumn(
                    $setup->getTable($tableName),
                    'google_review_url',
                    [
                        'type' =>  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Google Review URL'
                    ]
                );

            }

        }
        if (version_compare($context->getVersion(), '1.3.3') < 0) {
            $tableName = $setup->getTable('vapedirect_storefinder');
            if ($setup->getConnection()->isTableExists($tableName) == true) {

                $setup->getConnection()->addColumn(
                    $setup->getTable($tableName),
                    'notes',
                    [
                        'type' =>  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Shop Notification'
                    ]
                );

            }
        }
        $setup->endSetup();
    }
}


