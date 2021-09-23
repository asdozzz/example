CREATE TABLE IF NOT EXISTS event_store (
    event_id VARCHAR(64) NOT NULL,
    aggregate_root_id VARCHAR(64) NOT NULL,
    version int check (version > 0) NULL,
    payload varchar(16001) NOT NULL,
    PRIMARY KEY (event_id)
    ) ;

CREATE INDEX aggregate_root_id ON event_store (aggregate_root_id);
CREATE INDEX reconstitution ON event_store (aggregate_root_id, version ASC);

create table ekasko_nosql
(
    uuid varchar(64),
    data jsonb
);

create table ekasko
(
    uuid    varchar(64),
    status  varchar(32),
    premium double precision
);
