-- view_group_permissions
DROP VIEW IF EXISTS view_group_permissions CASCADE; 

CREATE OR REPLACE VIEW view_group_permissions AS (
	SELECT
		gp.group_id AS group_id,
		gp.perm_id AS perm_id,
		perm.name AS permission,
		grp.name AS group_name
	FROM
		aauth_group_permissions gp
	INNER JOIN aauth_groups grp ON (grp.id = gp.group_id)
	INNER JOIN aauth_permissions perm ON (perm.id = gp.perm_id)			
);

-- view_user_permissions
DROP VIEW IF EXISTS view_user_permissions CASCADE; 

CREATE OR REPLACE VIEW view_user_permissions AS (
	SELECT
		up.user_id AS user_id,
		up.perm_id AS perm_id,
		perm.name AS permission,
		u.username AS username,
		u.email AS email,
		u.fullname as fullname
	FROM
		aauth_user_permissions up
	INNER JOIN aauth_users u ON (u.id = up.user_id)
	INNER JOIN aauth_permissions perm ON (perm.id = up.perm_id)
);

-- view_user_groups
DROP VIEW IF EXISTS view_user_groups CASCADE; 

CREATE OR REPLACE VIEW view_user_groups AS (
	SELECT 
		ug.user_id AS user_id,
	    ug.group_id AS group_id,
	    g.name AS group_name,
	    u.username as username,
	    u.email as email,
	    u.fullname as fullname
   	FROM 
   		aauth_user_groups ug
    INNER JOIN aauth_users u ON (u.id = ug.user_id)
    INNER JOIN aauth_groups g ON (g.id = ug.group_id)
);

-- view_users
DROP VIEW IF EXISTS view_users CASCADE; 

CREATE OR REPLACE VIEW view_users AS (
	SELECT
		u.id AS id, 
		u.email AS email, 
		u.pass AS pass, 
		u.username AS username, 
		u.fullname as fullname,
		u.banned AS banned, 
		u.last_login AS last_login, 
		u.last_activity AS last_activity, 
		u.date_created AS date_created, 
		u.forgot_exp AS forgot_exp, 
		u.remember_time AS remember_time, 
		u.remember_exp AS remember_exp, 
		u.verification_code AS verification_code, 
		u.totp_secret AS totp_secret, 
		u.ip_address AS ip_address
	FROM
		aauth_users u
);
