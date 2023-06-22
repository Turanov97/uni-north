<?php

namespace RebelCode\Spotlight\Instagram\Performance\Analytics;

use RebelCode\Atlas\Table;
use RebelCode\Iris\Utils\Marker;
use RuntimeException;

class AnalyticsTables
{
    /** @var Table */
    protected $accountsTable;

    /** @var Table */
    protected $postsTable;

    /** @var Table */
    protected $engagementTable;

    /** @var Table */
    protected $promosTable;

    /** @var Marker */
    protected $didCreateMarker;

    /**
     * Constructor.
     *
     * @param Marker $didCreateMarker The marker that indicates whether the tables have been created.
     * @param Table $accountsTable The table used to store analytics for accounts.
     * @param Table $postsTable The table used to store analytics for posts.
     * @param Table $engagementTable The table used to store engagement for posts.
     * @param Table $promotionsTable The table used to store engagement for promotions.
     */
    public function __construct(
        Marker $didCreateMarker,
        Table $accountsTable,
        Table $postsTable,
        Table $engagementTable,
        Table $promotionsTable
    ) {
        $this->accountsTable = $accountsTable;
        $this->postsTable = $postsTable;
        $this->didCreateMarker = $didCreateMarker;
        $this->engagementTable = $engagementTable;
        $this->promosTable = $promotionsTable;
    }

    /**
     * Retrieves all the tables.
     *
     * @return Table[]
     */
    public function getTables(): array
    {
        return [$this->accountsTable, $this->postsTable, $this->engagementTable, $this->promosTable];
    }

    /** Retrieves the table that stores the analytics for accounts. */
    public function accounts(): Table
    {
        return $this->accountsTable;
    }

    /** Retrieves the table that stores the analytics for posts. */
    public function posts(): Table
    {
        return $this->postsTable;
    }

    /** Retrieves the table that stores the engagement for posts. */
    public function engagement(): Table
    {
        return $this->engagementTable;
    }

    /** Retrieves the table that stores analytics for promotions. */
    public function promoAnalytics(): Table
    {
        return $this->promosTable;
    }

    /** Creates the tables if they don't exist. */
    public function createTables(): void
    {
        if (!$this->didCreateMarker->isSet()) {
            global $wpdb;

            foreach ($this->getTables() as $table) {
                foreach ($table->create() as $query) {
                    $success = $wpdb->query($query);

                    if (!$success) {
                        $extra = empty($wpdb->error) ? "" : ' ' . $wpdb->error->get_error_message();
                        throw new RuntimeException("Failed to create the `{$table->getName()}` table.$extra");
                    }
                }
            }

            $this->didCreateMarker->create();
        }
    }

    /** Drops the tables if they exist. */
    public function dropTables(): void
    {
        if ($this->didCreateMarker->isSet()) {
            global $wpdb;

            foreach ($this->getTables() as $table) {
                $success = $wpdb->query($table->drop());

                if (!$success) {
                    $extra = empty($wpdb->error) ? "" : ' ' . $wpdb->error->get_error_message();
                    throw new RuntimeException("Failed to drop the `{$table->getName()}` table.$extra");
                }
            }

            $this->didCreateMarker->delete();
        }
    }
}
