// utils/db.js
import knex from 'knex';

// Using environment variables to connect to the Neon database
export const db = knex({
  client: 'pg',
  connection: {
    host: process.env.PGHOST,         // From .env (e.g., ep-still-bar-a76h9qn0.aws.neon.tech)
    user: process.env.PGUSER,         // From .env (your Neon username)
    password: process.env.PGPASSWORD, // From .env (your Neon password)
    database: process.env.PGDATABASE, // From .env (your Neon database name)
    ssl: { rejectUnauthorized: false }, // SSL required by Neon
  },
});

