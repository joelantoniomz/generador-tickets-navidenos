<?php
return ['default'=>env('CACHE_STORE','database'),'stores'=>['array'=>['driver'=>'array','serialize'=>false],'database'=>['driver'=>'database','table'=>'cache','connection'=>null,'lock_connection'=>null]],'prefix'=>env('CACHE_PREFIX','tickets_navidenos_cache')];
