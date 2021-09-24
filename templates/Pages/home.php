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
                Order me represents a web application based on CakePhp that organizes the orders placed by customers in the restaurant.<br>
                By using a device with a browser, connected to the web, the customer can read the menu without signing up on the application.<br>
                By logging in or creating an account, customers are able to check which tables are available and make a reservation.
                Next, it is possible to add the preferred dishes to the cart and press the order button. Once completed, the customer can make the payment and leave the table.<br>
                The user with admin role is able to see all the users’ reservations and orders and is also able to cancel an order.<br>
                 <h5 align="center">Here can find <a href="https://github.com/caiupi/orderme">OrderMe</a> source.</h5>

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
            This is just for university work so please don't destroy the databse. If you have any advice contact me at caiupi@yahoo.it
        </div>
    </div>
</div>


