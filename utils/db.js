// utils/db.js
import knex from 'knex';

// Using environment variables to connect to the Neon database
export const db = knex({
  client: 'pg', // PostgreSQL client
  connection: {
    host: process.env.PGHOST,         // The host from your .env
    user: process.env.PGUSER,         // The user from your .env
    password: process.env.PGPASSWORD, // The password from your .env
    database: process.env.PGDATABASE, // The database name from your .env
    ssl: { rejectUnauthorized: false }, // SSL is required for Neon connections
  },
});

