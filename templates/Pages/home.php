<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Desk[]|\Cake\Collection\CollectionInterface $desks
 */
?>
<div class="home index content" align="center">
    <?= $this->Html->link(__('Login'), ['controller'=>'Users','action' => 'login'], ['class' => 'button float-left']) ?>
    <?= $this->Html->link(__('Menu'), ['controller'=>'Dishs','action' => 'index'], ['class' => 'button float-right']) ?>
    <h3><?= __('OrderMe is a web application ') ?> </h3
    <div>
        <h4>OrderMe is a prototype web application used for university work. </h4>
        <div>
            <h6 align="left">
                OrderMe represent a web application based on CakePhp that organize the orders of the client on the restaurant. <br>
                The client using a device with browser, connected to the web, can read the menu which don't need to register to the application.
                Once the client login or register an account can see the available table and make a reservation.
                Next is possible to add the dishes that like to the cart and press the order.
                Once the order is press the client can make the payment and leave the table.<br>
                The user with admin role can see all the users reservations and orders and have the power to remove an order.


            </h6>
        </div>
        <br>
        <div>
            <h4>Instruction for the use of web application</h4>
            For regular user just register.
            <table>
                <thead>
                <tr>
                    <th>Administrator Email</th>
                    <th>Administrator Pass</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>admin@admin.com</td>
                        <td>admin</td>

                    </tr>
                </tbody>
            </table>
            This is just for university work so please dont destroy the application. If you have any advice contact me at caiupi@yahoo.it
        </div>
    </div>
</div>


