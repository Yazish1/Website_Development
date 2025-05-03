// utils/db.js

import knex from 'knex';

// Read environment variables from process.env
export const db = knex({
  client: 'pg',
  connection: {
    host: process.env.PGHOST,
    user: process.env.PGUSER,
    password: process.env.PGPASSWORD,
    database: process.env.PGDATABASE,
    port: 5432,  // Default PostgreSQL port
    ssl: { rejectUnauthorized: false },  // Needed for Neon
  },
});

