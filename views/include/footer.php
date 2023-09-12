<script src="<?=URL?>public/assets/js/bundle.js?ver=3.2.0"></script>
        <script src="<?=URL?>public/assets/js/scripts.js?ver=3.2.0"></script>
        <script src="<?=URL?>public/assets/js/charts/gd-default.js?ver=3.2.0"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>

    <?php
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>

</html>