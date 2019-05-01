DELETE FROM admin_pages WHERE page_key='configcompareProducts' LIMIT 1;
DELETE FROM configuration WHERE configuration_key LIKE 'COMPARE_%';
DELETE FROM configuration_group WHERE configuration_group_title = 'Compare Products Settings' LIMIT 1;