<?php
define('DEVELOPMENT_ENVIRONMENT', getenv('DEVELOPMENT_ENVIRONMENT'));

// database
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST'));

// file locations
define('IMAGE_DIR', ROOT . DS . 'storage' . DS . 'uploads' . DS . 'images');
define('TRACK_DIR', ROOT . DS . 'storage' . DS . 'uploads' . DS . 'tracks');
define('PCM_DIR', ROOT . DS . 'storage' . DS . 'pcm');
define('COMMENT_DIR', ROOT . DS . 'storage' . DS . 'comments');
define('VIEW_DIR', ROOT . DS . 'storage' . DS . 'views');


// other constants
define('BASE_PATH', getenv('BASE_PATH'));
define('PAGINATE_LIMIT', '10');
define('ERROR_PRES', ['Damn yo!', 'Uh oh!', 'Oh snap!', 'Say what!', 'WTF!']);
