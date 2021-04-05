# Changelog

All Notable changes to `backupmanager` will be documented in this file

----------
IMPORTANT
----------

We no longer use this file to track changes. Please see this repo's "Releases" tab, on Github:
https://github.com/Laravel-Backpack/BackupManager/releases

----------

## [3.0.0] - 2020-05-06

### Added
- support for Backpack 4.1;

### Removed
- support for Backpack 4.0 (just because icons are now ```la la-download``` instead of ```fa fa-download```);


----------


## [2.0.5] - 2020-04-20

### Added
- added names to routes @iMokhles (#80)


## [2.0.4] - 2020-03-05

### Fixed
- Upgraded PHPUnit;


## [2.0.3] - 2020-01-14

### Added
- Indonesian language file;


## [2.0.2] - 2019-12-19

### Added
- Farsi (Persian) language file;


## [2.0.1] - 2019-11-17

### Fixed
- merged #73 - notifications did not show;
- merged #75 - properly log backup erors now;


## [2.0.0] - 2019-09-24

### Added
- support for Backpack v4;

### Removed
- support for Backpack v3;


-----------


## [1.4.10] - 2019-09-01

### Added
- #70 - Russian language file;


## [1.4.9] - 2019-08-23

### Fixed
- changed config file to fit latest spatie/laravel-backup config file model;


## [1.4.8] - 2019-04-23

### Fixed
- merged #65 - using Artisan class instead of manually calling the same command line; this makes the AJAX wait for the answer, so the page reload will happen after the actual backup has been done;

## [1.4.7] - 2019-03-01

- better messages

## [1.4.6] - 2019-03-01

- added support for Base 1.1 and Laravel 5.8;
- dropped support for everything else;

## [1.4.5] - 2018-11-22

- added support for Base 1.0.x

## [1.4.4] - 2018-10-15

### Fixed
- monitored backups now has the correct disk name;


## [1.4.3] - 2018-10-15

### Fixed
- custom views folder is only loaded when it exists; this fixes the conflicts in the ```php artisan view:cache``` command;


## [1.4.2] - 2018-06-19

### Fixed
- config file has ```backpack_flags``` as array;
- config file has a ```temporary_directory``` defined;


## [1.4.0] - 2018-04-23

### Added
- Backpack\Base 0.9.x requirement;

### Removed
- support for Backpack\Base pre-0.9.0;
- notifications from being triggered, when the Create Backup button is pressed; new config option ```backpack_flags``` can overwrite this behaviour;


## [1.3.2] - 2017-12-02

### Added
- Turkish translation (thanks to [Yusuf Kaya](https://github.com/yusufkaya0));


## [1.3.1] - 2017-12-02

### Fixed
- working default configuration file for the new spatie/backup;


## [1.3.0] - 2017-12-02

### Fixed
- upgraded to Spatie/Backup v5; breaking change: config file is now named ```config/backup.php```;


## [1.2.0] - 2017-08-30

### Fixed
- upgraded to Spatie/Backup v4; breaking change: dump variables are now named inside an array in config/database.php;

### Added
- package auto-discovery;


## [1.1.18] - 2017-07-06

### Added
- overwritable routes file;


## [1.1.17] - 2017-07-05

### Added
- Portugese translation (thanks to [Toni Almeida](https://github.com/promatik));
- Portugese (Brasilian) translation (thanks to [Guilherme Augusto Henschel](https://github.com/cenoura));


## [1.1.16] - 2017-04-05

### Added
- French translation;
- Dutch translation (thanks to [Mark van Beek](https://github.com/chancezeus));
- fixed App namespace issue;

## [1.1.15] - 2017-01-21

### Added
- Ability to publish views;
- Ability to overwrite views the same way you overwrite views in CRUD;


## [1.1.14] - 2017-01-08

### Fixed
- removed duplicate namespace in BackupController;



## [1.1.13] - 2016-12-22

### Fixed
- delete route filename conflict - thanks to [Vincenzo Raco](https://github.com/vincenzoraco);


## [1.1.12] - 2016-12-13

### Added
- Greek translation file, thanks to [Stamatis Katsaounis](https://github.com/skatsaounis);


## [1.1.11] - 2016-09-24

### Fixed
- Routes now follow base prefix - thanks to [Twaambo Haamucenje](https://github.com/twoSeats);


## 1.1.10 - 2016-08-17

### Added
- Spanish translation, thanks to [Rafael Ernesto Ferro González](https://github.com/rafix);


## 1.1.9 - 2016-07-30

### Added
- Bogus unit tests. At least we'be able to use travis-ci for requirements errors, until full unit tests are done.


## 1.1.8 - 2016-07-25

### Fixed
- Download button with subfolders.


## 1.1.7 - 2016-07-13

### Added
- Showing files from multiple disks.
- Can delete files from other disks, other than local (tested Dropbox).

### Fixed
- Download link is no longer dependant on the suggested backups storage disk.
- Hidden download link if not using the Local filesystem.

### Removed
- Subfolder listing and downloading.

## 1.1.6 - 2016-06-03

### Fixed
- Download and delete buttons now work too, for subfolders.


## 1.1.5 - 2016-06-03

### Fixed
- Showing zip files from subfolders, too, since laravel-backup stores them that way.


## 1.1.4 - 2016-03-16

### Fixed
- Added page title.

## 1.1.3 - 2016-03-16

### Fixed
- Eliminated console logs from backup js.
- Added screenshot in README.

## 1.1.2 - 2016-03-16

### Fixed
- Made the backup button work.
- Added another error type - the warning when something failed.
- Logging the progress in the log files.
- Showing the artisan command output in the ajax response.
- Added the dump_command_path configuration.
- Changed README to instruct on common misconfiguration issue.


## 1.1.1 - 2016-03-15

### Fixed
- Correct name in readme. Confirming packagist hook.


## 1.1 - 2016-03-15

### Added
- Updated to v3 of spatie's laravel-backup package.
- Renamed everything to be part of Backpack instead of Dick.
