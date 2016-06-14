# noinspection SqlNoDataSourceInspectionForFile
INSERT INTO artifact_type (name) VALUES ('s3'), ('local'), ('jenkins'), ('bamboo');
INSERT INTO package_step_type (name) VALUES ('install'), ('uninstall'), ('validate'), ('upgrade'), ('downgrade');
INSERT INTO property_type (name) VALUES ('string');
INSERT INTO property (id, name, property_type_id) VALUES ('AUTH_API_URL', 'Authentication Context Api Url', 1);
INSERT INTO target_package_status (name) VALUES ('waiting'),('installing'),('installed'),('failed');