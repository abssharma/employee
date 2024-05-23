const express = require('express');
const bodyParser = require('body-parser');
const { Pool } = require('pg');

// Set up PostgreSQL connection
const pool = new Pool({
    user: 'postgres',
    host: 'localhost',
    database: 'phase3_1',
    password: '1234',
    port: 5432,
  });

const app = express();
app.use(bodyParser.urlencoded({ extended: true }));

// POST endpoint to handle the form submission
app.post('/addEmployee', async (req, res) => {
    try {
        const { first_name, last_name, preferred_name, role_id, experience, country_id } = req.body;
        
        const result = await pool.query(
            'INSERT INTO employee (first_name, last_name, preferred_name, role_id, experience, country_id) VALUES ($1, $2, $3, $4, $5, $6)',
            [first_name, last_name, preferred_name, role_id, experience, country_id]
        );

        res.json({ message: 'Employee added successfully', result: result.rows });
    } catch (error) {
        console.error(error);
        res.status(500).send('Error occurred while adding employee');
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
