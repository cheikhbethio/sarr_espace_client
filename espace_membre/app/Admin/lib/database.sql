CREATE TABLE `FILE` (

    `name` varchar(255) NOT NULL,
    `type` varchar(255) NULL,
    `updated_date` timestamp NOT NULL
    DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    `data` longblob NULL,

    PRIMARY KEY (`name`)

)TYPE=MyISAM;
