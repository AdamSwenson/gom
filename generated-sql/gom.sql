
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `displayname` VARCHAR(100) NOT NULL,
    `password` VARCHAR(225) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `activation_token` VARCHAR(225) NOT NULL,
    `last_activation_request` INTEGER(11) NOT NULL,
    `lost_password_request` INTEGER(1) NOT NULL,
    `active` INTEGER(1) NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `sign_up_stamp` INTEGER(11) NOT NULL,
    `last_sign_in_stamp` INTEGER(11) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- r_terms
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `r_terms`;

CREATE TABLE `r_terms`
(
    `content` VARCHAR(100) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`content`),
    INDEX `r_terms_fi_69bd79` (`user_id`),
    CONSTRAINT `r_terms_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- r_examTopics
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `r_examTopics`;

CREATE TABLE `r_examTopics`
(
    `content` VARCHAR(100) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`content`),
    INDEX `r_examTopics_fi_69bd79` (`user_id`),
    CONSTRAINT `r_examTopics_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- r_years
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `r_years`;

CREATE TABLE `r_years`
(
    `content` INTEGER(4) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`content`),
    INDEX `r_years_fi_69bd79` (`user_id`),
    CONSTRAINT `r_years_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- exams
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `exams`;

CREATE TABLE `exams`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `examTerm` VARCHAR(100) NOT NULL,
    `examTopic` VARCHAR(100) NOT NULL,
    `examYear` INTEGER(4) NOT NULL,
    `locked` INTEGER(1) NOT NULL,
    `released` INTEGER(1) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `exams_fi_69bd79` (`user_id`),
    INDEX `exams_fi_159d06` (`examTerm`),
    INDEX `exams_fi_6a54a1` (`examTopic`),
    INDEX `exams_fi_b3505d` (`examYear`),
    CONSTRAINT `exams_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `exams_fk_159d06`
        FOREIGN KEY (`examTerm`)
        REFERENCES `r_terms` (`content`),
    CONSTRAINT `exams_fk_6a54a1`
        FOREIGN KEY (`examTopic`)
        REFERENCES `r_examTopics` (`content`),
    CONSTRAINT `exams_fk_b3505d`
        FOREIGN KEY (`examYear`)
        REFERENCES `r_years` (`content`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- questions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `questionText` TEXT NOT NULL,
    `questionName` VARCHAR(100),
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `questions_fi_69bd79` (`user_id`),
    CONSTRAINT `questions_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- elements
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `elements`;

CREATE TABLE `elements`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `elementName` VARCHAR(100),
    `displayText` VARCHAR(225) NOT NULL,
    `commentText` TEXT,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `elements_fi_69bd79` (`user_id`),
    CONSTRAINT `elements_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- students
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `sid` INTEGER NOT NULL,
    `studentName` VARCHAR(200),
    `email` VARCHAR(225),
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `students_u_920f7a` (`sid`),
    INDEX `students_fi_69bd79` (`user_id`),
    CONSTRAINT `students_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- classes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `classes`;

CREATE TABLE `classes`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `year` INTEGER(4),
    `nickname` VARCHAR(100),
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `classes_fi_69bd79` (`user_id`),
    CONSTRAINT `classes_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- stockTexts
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `stockTexts`;

CREATE TABLE `stockTexts`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `valence` VARCHAR(255),
    `content` TEXT NOT NULL,
    `type` VARCHAR(255),
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `stockTexts_fi_69bd79` (`user_id`),
    CONSTRAINT `stockTexts_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- questionScores
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `questionScores`;

CREATE TABLE `questionScores`
(
    `examID` INTEGER NOT NULL,
    `questionID` INTEGER NOT NULL,
    `studentID` INTEGER NOT NULL,
    `questionScore` FLOAT,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`examID`,`questionID`,`studentID`),
    INDEX `questionScores_fi_69bd79` (`user_id`),
    INDEX `questionScores_fi_175030` (`studentID`),
    INDEX `questionScores_fi_048855` (`questionID`),
    CONSTRAINT `questionScores_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `questionScores_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `questionScores_fk_175030`
        FOREIGN KEY (`studentID`)
        REFERENCES `students` (`id`),
    CONSTRAINT `questionScores_fk_048855`
        FOREIGN KEY (`questionID`)
        REFERENCES `questions` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- elementScores
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `elementScores`;

CREATE TABLE `elementScores`
(
    `examID` INTEGER NOT NULL,
    `elementID` INTEGER NOT NULL,
    `studentID` INTEGER NOT NULL,
    `elementScore` FLOAT,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`examID`,`elementID`,`studentID`),
    INDEX `elementScores_fi_69bd79` (`user_id`),
    INDEX `elementScores_fi_fd5216` (`elementID`),
    INDEX `elementScores_fi_175030` (`studentID`),
    CONSTRAINT `elementScores_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `elementScores_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `elementScores_fk_fd5216`
        FOREIGN KEY (`elementID`)
        REFERENCES `elements` (`id`),
    CONSTRAINT `elementScores_fk_175030`
        FOREIGN KEY (`studentID`)
        REFERENCES `students` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- examInfo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `examInfo`;

CREATE TABLE `examInfo`
(
    `examID` INTEGER NOT NULL,
    `studentID` INTEGER NOT NULL,
    `completionOrder` INTEGER,
    `pages` FLOAT,
    `notecard` FLOAT,
    `examGroupNumber` INTEGER,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`examID`,`studentID`),
    INDEX `examInfo_fi_69bd79` (`user_id`),
    INDEX `examInfo_fi_175030` (`studentID`),
    CONSTRAINT `examInfo_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `examInfo_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `examInfo_fk_175030`
        FOREIGN KEY (`studentID`)
        REFERENCES `students` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- questionAssigner
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `questionAssigner`;

CREATE TABLE `questionAssigner`
(
    `examID` INTEGER NOT NULL,
    `questionNumber` INTEGER(2) NOT NULL,
    `questionID` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`examID`,`questionNumber`),
    INDEX `questionAssigner_fi_69bd79` (`user_id`),
    INDEX `questionAssigner_fi_048855` (`questionID`),
    CONSTRAINT `questionAssigner_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `questionAssigner_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `questionAssigner_fk_048855`
        FOREIGN KEY (`questionID`)
        REFERENCES `questions` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- elementXquestions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `elementXquestions`;

CREATE TABLE `elementXquestions`
(
    `examID` INTEGER NOT NULL,
    `questionID` INTEGER NOT NULL,
    `subtask` INTEGER(2) NOT NULL,
    `elementID` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`examID`,`questionID`,`subtask`),
    INDEX `elementXquestions_fi_69bd79` (`user_id`),
    INDEX `elementXquestions_fi_048855` (`questionID`),
    INDEX `elementXquestions_fi_fd5216` (`elementID`),
    CONSTRAINT `elementXquestions_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `elementXquestions_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `elementXquestions_fk_048855`
        FOREIGN KEY (`questionID`)
        REFERENCES `questions` (`id`),
    CONSTRAINT `elementXquestions_fk_fd5216`
        FOREIGN KEY (`elementID`)
        REFERENCES `elements` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- studentsXclasses
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `studentsXclasses`;

CREATE TABLE `studentsXclasses`
(
    `studentID` INTEGER NOT NULL,
    `classID` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`studentID`,`classID`),
    INDEX `studentsXclasses_fi_69bd79` (`user_id`),
    INDEX `studentsXclasses_fi_ab8f61` (`classID`),
    CONSTRAINT `studentsXclasses_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `studentsXclasses_fk_175030`
        FOREIGN KEY (`studentID`)
        REFERENCES `students` (`id`),
    CONSTRAINT `studentsXclasses_fk_ab8f61`
        FOREIGN KEY (`classID`)
        REFERENCES `classes` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- examsXclasses
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `examsXclasses`;

CREATE TABLE `examsXclasses`
(
    `classID` INTEGER NOT NULL,
    `examID` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`classID`,`examID`),
    INDEX `examsXclasses_fi_69bd79` (`user_id`),
    INDEX `examsXclasses_fi_71c1fe` (`examID`),
    CONSTRAINT `examsXclasses_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `examsXclasses_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `examsXclasses_fk_ab8f61`
        FOREIGN KEY (`classID`)
        REFERENCES `classes` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- time_grading
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `time_grading`;

CREATE TABLE `time_grading`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `examID` INTEGER NOT NULL,
    `studentID` INTEGER NOT NULL,
    `seconds` FLOAT,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `time_grading_u_0e7b81` (`examID`, `studentID`),
    INDEX `time_grading_fi_69bd79` (`user_id`),
    INDEX `time_grading_fi_175030` (`studentID`),
    CONSTRAINT `time_grading_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `time_grading_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `time_grading_fk_175030`
        FOREIGN KEY (`studentID`)
        REFERENCES `students` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- time_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `time_group`;

CREATE TABLE `time_group`
(
    `examID` INTEGER NOT NULL,
    `groupID` INTEGER NOT NULL,
    `seconds` FLOAT,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`examID`,`groupID`),
    INDEX `time_group_fi_69bd79` (`user_id`),
    CONSTRAINT `time_group_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `time_group_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- preferences
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `preferences`;

CREATE TABLE `preferences`
(
    `jqueryTheme` VARCHAR(100),
    `autostartExam` TINYINT(1),
    `autostartGroup` TINYINT(1),
    `dashboard_num_exams` INTEGER,
    `number_questions` INTEGER,
    `number_subtasks` INTEGER,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    INDEX `preferences_fi_69bd79` (`user_id`),
    CONSTRAINT `preferences_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pseudoIDs
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pseudoIDs`;

CREATE TABLE `pseudoIDs`
(
    `studentID` INTEGER NOT NULL,
    `examID` INTEGER NOT NULL,
    `pseudoID` VARCHAR(225) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`studentID`,`examID`),
    UNIQUE INDEX `pseudoIDs_u_aace2c` (`pseudoID`),
    INDEX `pseudoIDs_fi_69bd79` (`user_id`),
    INDEX `pseudoIDs_fi_71c1fe` (`examID`),
    CONSTRAINT `pseudoIDs_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `pseudoIDs_fk_71c1fe`
        FOREIGN KEY (`examID`)
        REFERENCES `exams` (`id`),
    CONSTRAINT `pseudoIDs_fk_175030`
        FOREIGN KEY (`studentID`)
        REFERENCES `students` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tags
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tag` VARCHAR(225) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `tags_u_24e05a` (`tag`),
    INDEX `tags_fi_69bd79` (`user_id`),
    CONSTRAINT `tags_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tagsXquestions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tagsXquestions`;

CREATE TABLE `tagsXquestions`
(
    `tag_id` INTEGER NOT NULL,
    `question_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`tag_id`,`question_id`),
    INDEX `tagsXquestions_fi_69bd79` (`user_id`),
    INDEX `tagsXquestions_fi_83fc93` (`question_id`),
    CONSTRAINT `tagsXquestions_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `tagsXquestions_fk_6bac06`
        FOREIGN KEY (`tag_id`)
        REFERENCES `tags` (`id`),
    CONSTRAINT `tagsXquestions_fk_83fc93`
        FOREIGN KEY (`question_id`)
        REFERENCES `questions` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tagsXelements
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tagsXelements`;

CREATE TABLE `tagsXelements`
(
    `tag_id` INTEGER NOT NULL,
    `element_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`tag_id`,`element_id`),
    INDEX `tagsXelements_fi_69bd79` (`user_id`),
    INDEX `tagsXelements_fi_88cff7` (`element_id`),
    CONSTRAINT `tagsXelements_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `tagsXelements_fk_6bac06`
        FOREIGN KEY (`tag_id`)
        REFERENCES `tags` (`id`),
    CONSTRAINT `tagsXelements_fk_88cff7`
        FOREIGN KEY (`element_id`)
        REFERENCES `elements` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
