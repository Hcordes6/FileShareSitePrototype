[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/pzaS41nk)
# CSE3300
Henry Cordes 525454 hcordes6

Yaroslav Parashchiy 605566 yaroslav-06

http://ec2-3-147-57-126.us-east-2.compute.amazonaws.com/~parolk/mod3/module3-group-module3-525454-605566/NewsSite/newsSite.php

<br><br><br>


Setup databse: 

create database newsSite;
create user 'wustl_inst'@'localhost' identified by 'wustl_pass';
grant all on newsSite to 'wustl_inst'@'localhost' with grant option;
flush privileges;

setup tables: 

```sql
create table users (
    user_id         int unsigned not null auto_increment,
    username        varchar(20) not null,
    password_hash   varchar(255) not null,
    email           varchar(50) not null,
    primary key (user_id),
    unique key (username),
    unique key (email)
) engine = InnoDB default character set = utf8 collate = utf8_general_ci;

create table posts (
    id          int unsigned not null auto_increment,
    user_id     int unsigned not null,
    title       varchar(200) not null,
    body        varchar(2000) not null,
    link        varchar(300),
    vote_count  int default 0,
    created     timestamp not null default current_timestamp,
    foreign key (user_id) references users (user_id),
    primary key (id)
) engine = InnoDB default character set = utf8 collate = utf8_general_ci;

create table comments (
    id      int unsigned auto_increment,
    post_id int unsigned not null,
    user_id int unsigned not null,
    text    varchar(200) not null,
    primary key (id),
    foreign key (post_id) references posts (id),
    foreign key (user_id) references users (user_id),
    index idx_post_id (post_id)
) engine = InnoDB default character set = utf8 collate = utf8_general_ci;

create table votes (
    id          int unsigned auto_increment,
    user_id     int unsigned not null,
    story_id    int unsigned not null,
    vote_value  tinyint not null,  -- 1 for upvote, -1 for downvote
    created_at  timestamp not null default current_timestamp,
    primary key (id),
    unique key unique_vote (user_id, story_id),
    foreign key (user_id) references users (user_id) on delete cascade,
    foreign key (story_id) references posts (id) on delete cascade
) engine = InnoDB default character set = utf8 collate = utf8_general_ci;
```

For creative portion we added My Votes option on main page to show the stories you have voted on.

 # AI Reflection
Answer the following questions below


 ## Before Coding
* What is the goal of this assignment?

The goal of this assignment is to create a new site, where users can register, login and post stories and comments. Each post will have an upvote/downvote feature created by AI agent mode. In addition, there will be another smaller creative feature. 

* When will you use AI, and when will you avoid it?

We will use AI for when we get stuck, helping clarify questions, and for the AI requirement when it comes to the upvote/downvote feature. We will avoid having it generate bulk code aside from the AI requirement. 

* What conceptual questions did you ask the AI?

what does "require" do functionally in php?

## During Development 
* Paste your three most useful AI prompts.

what does "require" do functionally in php?

I want to implement the comment section under any post, so I'm thinking of creating another sql table to save all comments, but would it be to slow then to get all the comments from the table, the other solution would be to create a table for each post, but it also seems wrong

Why does pressing the edit post button as the user cause the post to be deleted instead of opening the edit menu?

* What was the AI’s response? (Summarize.)

For the first one, Require essentially works the same as include in other languages. It includes the target file and runs the code immediately, any classes, variables, methods or anything else defined in it will also be included.

For the second one, the prompt was sent in plan mode. It was able to verify that there was an easier, more efficient way to implement the comments, by creating a separate table, but use foreign keys to reference it to the post it is associated with. It also suggested implementing an index to each comment, so that they could efficiently be referenced when attempting to display them. If we were just using foreign keys, we would still have to loop through each comment entry and check its foreign key status.

For the third one, the AI was able to debug and detect why the logic on our edit button was incorrect. It was deleting the post, which suggested that it was clashing with the delete button form. The AI suggested a fix, which instead of redirecting the user on click, it would change the form action. 

* What did you change in the AI’s output, and why?

AI had a lot of issues with styling. Many times, it was necessary to reprompt for styling fixes, or fix it manually. In particular, with flexbox features, causing components to be squished together. 

* What worked and what did not? (Be specific.)

Using the plan feature worked really well. It was able to lay down a good roadmap for adding features. In terms of the AI upvote/downvote portion of the assignment, it was really great at handling the logic, and outlining what we needed to do with initializing sql tables. It struggled with styling. The flexbox issues came from implementing this feature. 

## After Completion
* What errors did the AI make that you caught?

As mentioned before, many styling errors. We were careful with context to make sure that it knew how to implement code within the existing codebase. There was a time or two where the AI didnt quite understand the schema of our sql table, which caused another prompt to be needed. 

* What debugging or testing did you do?

We prompted ai to make sure that we were using proper web security protocol, including FIEO, sql injection protection, salting/hashing, and CSRF tokens. 

* What did you understand better because of the AI?

We better understood sql concepts (such as built-in timestamp functionality), specific php and sql norms and structure. 

* What would you change about how you use AI next time?

When the AI uses something that I dont know, I want to ask what it means, instead of trying to work around it or deleting it altogether. We also want to experiment with plan mode more. 

### Submit your AI Interaction log
* Your CSE_3300_AI_LOG.md file should include copy-pasted prompts and responses from any AI tools you used in CSE_3300_AI_LOG.md file. 




<br><br><br><br><br><br><br><br><br>
Rubric


| Possible | Requirement                                                                      |
| -------- | -------------------------------------------------------------------------------- | 
| 3        | A session is created when a user logs in                                         | 
| 3        | New users can register                                                           | 
| 3        | Passwords are hashed and salted                                                  | 
| 3        | Users can log out                                                                | 
| 8        | User can edit and delete their own stories/comments but not those of other users | 
| 4        | Relational database is configure with correct data types and foreign keys        | 
| 3        | Stories can be posted                                                            | 
| 3        | A link can be associated with each story and is stored in its own database field | 
| 4        | Comments can be posted in association with a story                               | 
| 3        | Stories can be edited and deleted                                                |
| 3        | Comments can be edited and deleted                                               | 
| 3        | Code is well formatted and easy to read                                          |
| 2        | Safe from SQL injection attacks                                                  | 
| 3        | Site follows FIEO                                                                | 
| 2        | All pages pass the W3C validator                                                 | 
| 5        | CSRF tokens are passed when creating, editing, and deleting comments/stories     |
| 4        | Site is intuitive to use and navigate                                            | 
| 1        | Site is visually appealing                                                       |  

## Creative Portion and AI Integration (15 possible)

| Feature | 
| ------- |

## Grade

| Total Possible |
| -------------- |
| 75             |
