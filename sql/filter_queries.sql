# Get all with user info ()
SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users
	ON points_of_interest.user_id = users.id
	ORDER BY created_at DESC;

# W
SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = "Overworld"
	ORDER BY created_at DESC;
 
# C
SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE category = "Spawner"
	ORDER BY created_at DESC;


# WC
SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = "Overworld"
	AND category = "Spawner"
	ORDER BY created_at DESC;

# WP
SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username,
	SQRT(((x - 500)*(x - 500) + (z - 1000)*(z - 1000))) AS distance
	FROM points_of_interest 
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = "Overworld"
	ORDER BY distance;

# WCP
SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username,
	SQRT(((x - 500)*(x - 500) + (z - 1000)*(z - 1000))) AS distance
	FROM points_of_interest 
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = "Overworld"
	AND category = "Spawner"
	ORDER BY distance;
