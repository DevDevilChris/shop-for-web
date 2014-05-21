<?php
/**
 * Created by PhpStorm.
 * User: chrissmits
 * Date: 21/05/14
 * Time: 18:01
 */

class SeedStatus extends Seeder {

    public function run()
    {
        DB::table('order_status')->delete();

        DB::table('order_status')->insert(array(
            array(
                'status' => 'Prepared'
            ),
            array(
                'status' => 'Payed'
            ),
            array(
                'status' => 'Sent'
            ),
            array(
                'status' => 'Returned'
            ),
            array(
                'status' => 'Invoiced'
            ),
            array(
                'status' => 'Cancelled'
            ),
        ));
    }

} 