CREATE TABLE tx_github_webhook (
    title varchar(64) DEFAULT '' NOT NULL,
    content_type varchar(32) DEFAULT '' NOT NULL,
    secret varchar(32) DEFAULT '' NOT NULL,
    shell text,
);