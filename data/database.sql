CREATE TABLE Users(username varchar(30) PRIMARY KEY, 
                  password varchar(256) NOT NULL, 
                  first_name varchar(30) NOT NULL,
                  last_name varchar(30) NOT NULL,
                  email varchar(30));

CREATE TABLE Projects(project_id serial PRIMARY KEY, name varchar(50), 
                      description varchar(256), 
                      deadline DATE);

CREATE TABLE UsersAndProjects(project_id INTEGER REFERENCES Projects(project_id), 
                              username varchar(30) REFERENCES Users(username),
                              PRIMARY KEY (project_id, username));

                        
CREATE TABLE Tasks(taskid serial PRIMARY KEY, content varchar(30), deadline DATE,
                   username varchar(30) REFERENCES Users(username));

CREATE TABLE Contacts(username varchar(30) REFERENCES Users(username), 
                      contact varchar(30) REFERENCES Users(username),
                      PRIMARY KEY(username, contact));
