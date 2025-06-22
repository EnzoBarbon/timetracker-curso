-- Create the clocking_days table
CREATE TABLE clocking_days (
    id BIGINT PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    user_id UUID NOT NULL,
    date DATE NOT NULL,
    check_in TIME,
    check_out TIME,
    notes TEXT,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW(),
    CONSTRAINT fk_user
        FOREIGN KEY(user_id)
        REFERENCES auth.users(id)
        ON DELETE CASCADE
);

-- Create the horas_teoricas table
CREATE TABLE horas_teoricas (
    id BIGINT PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    date DATE NOT NULL UNIQUE,
    hours DECIMAL(4, 2) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Add comments to the tables and columns for clarity
COMMENT ON TABLE clocking_days IS 'Stores daily check-in and check-out times for users.';
COMMENT ON TABLE horas_teoricas IS 'Stores the theoretical working hours for a given day.';
