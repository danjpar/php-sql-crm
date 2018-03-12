<?php if (login_check($mysqli) == true) : ?>

<ul class="head-nav" style="list-style:none;">
<li><a href="addnew.php">add new</a></li>
<li><a href="inquiry.php">inquiries</a></li>
<li><a href="contacts.php">contacts</a></li>
<li><a href="search.php">search</a></li>
</ul>
</br>
<?php else : ?>
            <p>
                <span class="error">You are not authorized.</span> Please <a href="index.php">login</a>.
            </p>
<?php endif; ?>