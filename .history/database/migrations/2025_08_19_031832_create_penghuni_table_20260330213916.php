2026_03_30_142700_create_rumah_table ................................................................................................ 33.02ms FAIL

   Illuminate\Database\QueryException

  SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'penghuni' already exists (Connection: mysql, SQL: create table `penghuni` (`id` bigint unsigned not null auto_increment primary key, `nama` varchar(100) not null, `no_ktp` varchar(20) not null, `email` varchar(100) not null, `telepon` varchar(20) null, `alamat` varchar(150) not null, `rumah_id` bigint unsigned null, `status` enum('Aktif', 'Tidak Aktif') not null default 'Aktif', `status_huni` enum('Tetap', 'Kontrak') not null default 'Tetap', `tanggal_masuk` date null, `tanggal_keluar` date null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_0900_ai_ci')

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:825
    821▕                     $this->getName(), $query, $this->prepareBindings($bindings), $e
    822▕                 );
    823▕             }
    824▕
  ➜ 825▕             throw new QueryException(
    826▕                 $this->getName(), $query, $this->prepareBindings($bindings), $e
    827▕             );
    828▕         }
    829▕     }

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:571
      PDOException::("SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'penghuni' already exists")

  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:571
      PDOStatement::execute()
