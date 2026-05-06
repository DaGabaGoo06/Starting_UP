

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50),
    Last_Name VARCHAR(50),
    Email VARCHAR(100),
    Password VARCHAR(255),
    Role ENUM('investitor', 'startup', 'admin')
);

CREATE TABLE Startups (
    id INT PRIMARY KEY AUTO_INCREMENT,
    startup_Name VARCHAR(100),
    Description TEXT,
    Industry VARCHAR(100),
    owner_id INT,
    FOREIGN KEY (owner_id) REFERENCES Users(UserID)
);

CREATE TABLE Investments (
    Inv_ID INT PRIMARY KEY AUTO_INCREMENT,
    startup_ID INT,
    investor_ID INT,
    Amount DECIMAL(15,2),
    Date DATE,
    FOREIGN KEY (startup_ID) REFERENCES Startups(id),
    FOREIGN KEY (investor_ID) REFERENCES Users(UserID)
);

CREATE TABLE Reports (
    Rep_id INT PRIMARY KEY AUTO_INCREMENT,
    data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    generated_by INT,
    FOREIGN KEY (generated_by) REFERENCES Users(UserID)
);

CREATE TABLE Notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    message TEXT,
    status ENUM('unread', 'read'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(UserID)
);

CREATE TABLE Comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    startup_id INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(UserID),
    FOREIGN KEY (startup_id) REFERENCES Startups(id)
);

CREATE TABLE Logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(255),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(UserID)
);