CREATE TABLE showtimes (
    showtimeID INT PRIMARY KEY AUTO_INCREMENT,
    movieID INT,
    showtimeDate DATE,
    showtimeTime TIME,
    hall VARCHAR(255),
    price DECIMAL(10, 2),
    FOREIGN KEY (movieID) REFERENCES movieTable(movieID)
);
