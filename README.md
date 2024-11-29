# SQL-script

## Brukertabell
```sql
CREATE TABLE IF NOT EXISTS accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') DEFAULT 'student',
    regDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    profileUrl VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### For å oppdatere brukertabellen med en kolonne for url til profilbilde
```sql
ALTER TABLE accounts
ADD COLUMN profileUrl VARCHAR(255) DEFAULT NULL;
```

## Oppgaver / tasks
```sql
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    due_date DATETIME,
    status ENUM('not-started', 'pending', 'completed', 'inactive'),
    course_code VARCHAR(20), -- Felt for emnekode
    collaboration BOOLEAN DEFAULT FALSE, -- Felt for samarbeid, satt til FALSE som standard
    material_url VARCHAR(255), -- Felt for kursmateriell, lagrer filsti eller URL
    FOREIGN KEY (user_id) REFERENCES accounts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Gjøremål / todo
```sql
CREATE TABLE IF NOT EXISTS todo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    value TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES accounts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

# Filstruktur

Filstrukturen er basert på https://github.com/php-pds/skeleton som vist i tabellen under.


| If a package has a root-level directory for ... | ... then it MUST be named: |
| ----------------------------------------------- | -------------------------- |
| command-line executables                        | `bin/`                     |
| configuration files                             | `config/`                  |
| documentation files                             | `docs/`                    |
| web server files                                | `public/`                  |
| other resource files                            | `resources/`               |
| PHP source code                                 | `src/`                     |
| test code                                       | `tests/`                   |
