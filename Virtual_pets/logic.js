// Import the database connection
const dbConnection = require('./db');

function calculate_points(points) {
    // Fetch user points from the database
    dbConnection.query('SELECT user_points FROM users WHERE user_id = ?', [user_id], function(err, result) {
        if (err) {
            console.error('Error fetching user points:', err);
            return;
        }

        const userPoints = result[0].points;

        if (userPoints <= 50) {
            // Display photo number 1 and a message
            console.log('Displaying photo number 1');
            console.log('Your pet is growing.. keep working and feed it with some more exercises');
        } else if (userPoints > 50 && userPoints <= 100) {
            // Display photo number 2 and a message
            console.log('Displaying photo number 2');
            console.log('Your little pet is not small anymore.. keep it up');
        } else if (userPoints > 100) {
            // Display photo number 3 and a message
            console.log('Displaying photo number 3');
            console.log('Your pet is an adult now thanks to your hardworking.. keep it up');
        }
    });
}

// Call the function with a sample points value
const samplePoints = 75;
calculate_points(samplePoints);