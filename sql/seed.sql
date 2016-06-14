# noinspection SqlNoDataSourceInspectionForFile
INSERT INTO artifact_type (id, name) VALUES (1, 's3'), (2, 'local'), (3, 'jenkins'), (4, 'bamboo');
INSERT INTO package_step_type (id, name) VALUES (1, 'install'), (2, 'uninstall'), (3, 'validate'), (4, 'upgrade'), (5, 'downgrade');
INSERT INTO property_type (id, name) VALUES ('AUTH_API_URL', 'Authentication Context Api Url');