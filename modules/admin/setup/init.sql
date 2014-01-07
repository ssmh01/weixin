INSERT INTO `yyx_menu` (`id`, `name`, `url`, `parent_id`, `status`, `is_system`, `sort_num`) VALUES
(1, '系统管理', '/admin/config/', 0, 1, 0, 0),
(2, '系统设置', '/admin/config/', 1, 1, 0, 0),
(3, '菜单管理', '/admin/menu/', 1, 1, 0, 0),
(4, '邮件模板', '/admin/emailTemplate/', 1, 1, 0, 0);

INSERT INTO `yyx_manage_group` (`id`, `name`, `permissions`, `summary`) VALUES
(1, '超级管理员', '', '超级管理员拥有所有操作的权限');

INSERT INTO `yyx_manager` (`id`, `name`, `password`,`mobile`,`group_id`, `allow_login`, `last_login_time`, `create_time`) VALUES
(1, 'admin', '14e1b600b1fd579f47433b88e8d85291', '', 1, 1, '', '');