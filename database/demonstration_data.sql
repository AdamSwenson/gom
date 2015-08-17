# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.25)
# Database: gom_lar
# Generation Time: 2015-08-05 20:41:54 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table access_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `access_keys`;

CREATE TABLE `access_keys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `access_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `access_keys_user_id_index` (`user_id`),
  KEY `access_keys_access_key_index` (`access_key`),
  KEY `access_keys_student_id_index` (`student_id`),
  KEY `access_keys_exam_id_index` (`exam_id`),
  CONSTRAINT `access_keys_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `access_keys_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `access_keys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `element_id` int(10) unsigned NOT NULL,
  `valence` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_element_id_foreign` (`element_id`),
  CONSTRAINT `comments_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`id`, `user_id`, `element_id`, `valence`, `body`, `created_at`, `updated_at`)
VALUES
	(1,1,5,'0','Your answer didn\'t explain the general payoff structure that figures in each person\'s decision making. More importantly, you needed to explain how tragedies of the commons involve a threshold so that there is room for some people to cheat without there being any problem overall. That\'s, in part, because each person\'s individual contribution, on its own, has no effect on the overall situation. That is, if they were the only one doing the activity, the problem would not arise. I didn\'t really see any of this (or at least enough detail on it) in your answer.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,5,'1','You had a lot of trouble explaining the general payoff structure that figures in each person\'s decision making. More importantly, you needed to explain how tragedies of the commons involve a threshold so that there is room for some people to cheat without there being any problem overall. That\'s, in part, because each person\'s individual contribution, on its own, has no effect on the overall situation. That is, if they were the only one doing the activity, the problem would not arise. Your answer did an okay job on some of this. But it was pretty weak on the other parts.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,5,'2','You did a solid job explaining the general payoff structure that figures in each person\'s decision making. More importantly, you needed to explain how tragedies of the commons involve a threshold so that there is room for some people to cheat without there being any problem overall. That\'s, in part, because each person\'s individual contribution, on its own, has no effect on the overall situation. That is, if they were the only one doing the activity, the problem would not arise. Your discussion did all of these things adequately. Though some parts were weaker than others.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,5,'3','Your awesome answer did a great job of explaining the general payoff structure that figures in each person\'s decision making. More importantly, you did an excellent job of explaining how tragedies of the commons involve a threshold so that there is room for some people to cheat without there being any problem overall. That\'s, in part, because each person\'s individual contribution, on its own, has no effect on the overall situation. That is, if they were the only one doing the activity, the problem would not arise.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,1,6,'0','Your answer missed the second central aspect of a tragedy of the commons. The Tragedy of the Commons is something more specific than the fact that things can go badly if we all act selfishly. These are situations where  people cannot rationally cooperate to avoid a bad outcome even if they all wanted to. The difference lies in the specific strategy that it is rational for people to pursue. In deciding whether to cooperate with the plan or to cheat there are basically two possible futures: (a)  Enough other people cooperate with the plan to avoid disaster or (b) Enough people cheat that there will be disaster. Either way, the best thing for you to do is cheat. In (a) the disaster will not happen, so you can get the benefit without the downside. In (b) you are screwed anyway, so might as well get something out of it. To tie this in with the first task, you probably needed to discuss the case of someone who wanted to be responsible and weigh the possible disaster in her calculations of what to do.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,1,6,'1','Your answer didn\'t really capture the second aspect of a tragedy of the commons. The Tragedy of the Commons is something more specific than the fact that things can go badly if we all act selfishly. These are situations where  people cannot rationally cooperate to avoid a bad outcome even if they all wanted to. The difference lies in the specific strategy that it is rational for people to pursue. In deciding whether to cooperate with the plan or to cheat there are basically two possible futures: (a)  Enough other people cooperate with the plan to avoid disaster or (b) Enough people cheat that there will be disaster. Either way, the best thing for you to do is cheat. In (a) the disaster will not happen, so you can get the benefit without the downside. In (b) you are screwed anyway, so might as well get something out of it. To tie this in with the first task, you probably needed to discuss the case of someone who wanted to be responsible and weigh the possible disaster in her calculations of what to do.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,1,6,'2','Your answer did a decent job in exploring the second aspect of a tragedy of the commons. But it wasn\'t as complete as it could have been. The Tragedy of the Commons is something more specific than the fact that things can go badly if we all act selfishly. These are situations where  people cannot rationally cooperate to avoid a bad outcome even if they all wanted to. The difference lies in the specific strategy that it is rational for people to pursue. In deciding whether to cooperate with the plan or to cheat there are basically two possible futures: (a)  Enough other people cooperate with the plan to avoid disaster or (b) Enough people cheat that there will be disaster. Either way, the best thing for you to do is cheat. In (a) the disaster will not happen, so you can get the benefit without the downside. In (b) you are screwed anyway, so might as well get something out of it. To tie this in with the first task, you probably needed to discuss the case of someone who wanted to be responsible and weigh the possible disaster in her calculations of what to do.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,1,6,'3','You did an excellent job of explaining how cheating is strictly dominant. That is, no matter what everyone else does, it is still in your interest to cheat. It was important to set out how this is true even if everyone is fully knowledgeable about the situation and rational in their decision making. Because of the thresholds that are part of the payoff structure/situation, this even applies to someone who wanted to be responsible and weigh the possible disaster in her calculations of what to do.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,1,7,'0','Any abstract discussion needs at least one good concrete example. In distinguishing between genuine tragedies of the commons and other kinds of situations, the details can be very important. You didn\'t do this. Thus your description of the cases had trouble clearly distinguishing between tragedy of the commons cases and ordinary cases in which, for example, many small harms add up, or where widespread irresponsibility or selfishness harm everyone. It can be a bit tricky to choose examples which do what I\'m looking for here. So if you have any questions about what was needed, please come talk to me. This will be important on the next exam.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,1,7,'1','Any abstract discussion needs at least one concrete example. In distinguishing between genuine tragedies of the commons and other kinds of situations, the details can be very important. Your example didn\'t help distinguish tragedy of the commons cases from ordinary cases in which, for example, many small harms add up, or where widespread irresponsibility or selfishness harm everyone. It can be a bit tricky to explain examples in the way that I?m looking for. So if you have any questions about what was needed, please come talk to me. This will be important on the next exam.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,1,7,'2','Any abstract discussion needs at least one concrete example. In distinguishing between genuine tragedies of the commons and other kinds of situations, the details can be very important. You did a decent job here. Your example was pretty clearly different from ordinary cases in which, for example, many small harms add up, or where widespread irresponsibility or selfishness harm everyone. Though a bit more care in spelling out the details of the example or explicitly tying them to the explanation would have helped.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,1,7,'3','Any abstract discussion needs at least one concrete example. In distinguishing between genuine tragedies of the commons and other kinds of situations, the details can be very important. You did an excellent job here. Your example cleanly distinguished tragedies of the commons from ordinary cases in which, for example, many small harms add up, or where widespread irresponsibility or selfishness harm everyone.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,1,1,'0','Your explanation did not show how moral hazards can be present in some kinds of policies like insurance or aid. From your answer it is not clear why we must be on the lookout for moral hazards and design our policies to reduce them as much as possible without losing sight of the importance of acting.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,1,1,'1','You did an okay job in explaining how moral hazards can be present in some kinds of policies like insurance or aid. Though from your answer it is not entirely clear why we must be on the lookout for moral hazards and design our policies to reduce them as much as possible without losing sight of the importance of acting.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,1,1,'2','You did a pretty good job in explaining how moral hazards can be present in some kinds of policies like insurance or aid. From your answer it is mostly clear why we must be on the lookout for moral hazards and design our policies to reduce them as much as possible without losing sight of the importance of acting.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(16,1,1,'3','You did an excellent job in explaining how moral hazards can be present in some kinds of policies like insurance or aid. From your answer it is crystal clear why we must be on the lookout for moral hazards and design our policies to reduce them as much as possible without losing sight of the importance of acting. ','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(17,1,2,'0','It is really important to be clear that moral hazards are one very specific kind of unintended consequence. Like all unintended consequences, they involve someone doing something to help a situation which actually ends up making things worse. But they are special in that moral hazards only arise when the intervention takes away the risks associated with doing the bad thing. Thus moral hazards actually make it more beneficial for someone to do the thing that is trying to be prevented. Your explanation failed to do this.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,1,2,'1','It is really important to be clear that moral hazards are one very specific kind of unintended consequence. Like all unintended consequences, they involve someone doing something to help a situation which actually ends up making things worse. But they are special in that moral hazards only arise when the intervention takes away the risks associated with doing the bad thing. Thus moral hazards actually make it more beneficial for someone to do the thing that is trying to be prevented. I think you had the general idea. But it wasn\'t totally clear from the way you explained the concept.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(19,1,2,'2','It is really important to be clear that moral hazards are one very specific kind of unintended consequence. Like all unintended consequences, they involve someone doing something to help a situation which actually ends up making things worse. But they are special in that moral hazards only arise when the intervention takes away the risks associated with doing the bad thing. Thus moral hazards actually make it more beneficial for someone to do the thing that is trying to be prevented. This was pretty clear from the way you explained the concept.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,1,2,'3','It is really important to be clear that moral hazards are one very specific kind of unintended consequence. Like all unintended consequences, they involve someone doing something to help a situation which actually ends up making things worse. But they are special in that moral hazards only arise when the intervention takes away the risks associated with doing the bad thing. Thus moral hazards actually make it more beneficial for someone to do the thing that is trying to be prevented. That is exactly what I got out of your awesome discussion of this point.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,1,3,'0','The tricky part of this question was giving a good example. Since the definition of moral hazard is precise, it is extremely important to give an example (with enough details) that exactly matches each part of the definition. Your example didn?t do this. It was an example of something more general than a moral hazard. Please, please, please talk to me so that you can get straight on what I mean by making the example match the definition. This approach to giving examples will be extremely important on parts of the next exam.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,1,3,'1','The tricky part of this question was giving a good example. Since the definition of moral hazard is precise, it is extremely important to give an example (with enough details) that exactly matches each part of the definition. You had some trouble doing this. Your example was in the ballpark. But it departed from the precise definition of a moral hazard. If you have any questions about what I mean by making the example match the definition, please ask me. This approach to giving examples will be extremely important on parts of the next exam.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,1,3,'2','The tricky part of this question was giving a good example. Since the definition of moral hazard is precise, it is extremely important to give an example (with enough details) that exactly matches each part of the definition. You did a solid job on this front. If you have any questions about what I mean by making the example match the definition, please ask me. This approach to giving examples will be extremely important on parts of the next exam.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,1,3,'3','The tricky part of this question was giving a good example. Since the definition of moral hazard is precise, it is extremely important to give an example (with enough details) that exactly matches each part of the definition. Your execution of this task was amongst the best in the class! That is especially good since this approach to giving examples will be extremely important on parts of the next exam.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(25,1,4,'0','','0000-00-00 00:00:00','2015-08-04 17:49:25'),
	(26,1,4,'1','','0000-00-00 00:00:00','2015-08-04 17:49:25'),
	(27,1,4,'2','','0000-00-00 00:00:00','2015-08-04 17:49:25'),
	(28,1,4,'3','','0000-00-00 00:00:00','2015-08-04 17:49:25'),
	(31,1,15,'0','The setup of the question is that the pure consequentialist seems to be committed to saying that the completely leveled down world is the ideal distribution of resources. But at the same time, it is easy to find reasons to doubt this. In that sort of situation, it is important to make sure that you aren\'t attacking an unnecessarily weak argument. Thus it is really important to explain the reasoning that leads to the conclusion. Namely, because a big loss for a small number of people will be outweighed by a small gain for each of a very large number of people, the amount of good in the world increases at every step until we reach Z.  Once you have explained how that fits with the consequentialist\'s claim that the right action is the action which maximizes good, the reader will be able to clearly see why there seems to be a problem lurking here for consequentialists in general and Singer in particular. You really did not do this at all. Thus I don\'t think a reader would really have any sense of why consequentialism (a major moral theory) is at all worth taking seriously.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(32,1,15,'1','The setup of the question is that the pure consequentialist seems to be committed to saying that the completely leveled down world is the ideal distribution of resources. But at the same time, it is easy to find reasons to doubt this. In that sort of situation, it is important to make sure that you aren?t attacking an unnecessarily weak argument. Thus it is really important to explain the reasoning that leads to the conclusion. Namely, because a big loss for a small number of people will be outweighed by a small gain for each of a very large number of people, the amount of good in the world increases at every step until we reach Z.  Once you have explained how that fits with the consequentialist?s claim that the right action is the action which maximizes good, the reader will be able to clearly see why there seems to be a problem lurking here for consequentialists in general and Singer in particular. I think you did enough for a reader to get a very general sense of this. But not nearly enough for them to have the sort of grasp on exactly what?s going on I want you to be able to give.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(33,1,15,'2','You did a decent job of explaining why the pure consequentialist seems to committed to saying that the completely leveled down world is the ideal distribution of resources. But at the same time, it is easy to find reasons to doubt this. Thus since you understand the need to avoid attacking unnecessarily weak arguments, you went into detail on the reasoning that leads to this conclusion. Though it could have been clearer, you adequately set out how a big loss for a small number of people will be outweighed by a small gain for each of a very large number of people, and thus the amount of good in the world increases at every step until we reach Z.  By at least implicitly explaining how that fits with the consequentialist?s claim that the right action is the action which maximizes good, I think a reader would have a decent sense of why there seems to be a problem lurking here for consequentialists in general and Singer in particular. ','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(34,1,15,'3','You did an excellent job in explaining why the pure consequentialist seems to committed to saying that the completely leveled down world is the ideal distribution of resources. But at the same time, it is easy to find reasons to doubt this. Thus since you understand the need to avoid attacking unnecessarily weak arguments, you went into detail on the reasoning that leads to this conclusion. You clearly explained how a big loss for a small number of people will be outweighed by a small gain for each of a very large number of people, and thus the amount of good in the world increases at every step until we reach Z.  By explaining how that fits with the consequentialist?s claim that the right action is the action which maximizes good, you made it clear to the reader why there seems to be a problem lurking here for consequentialists in general and Singer in particular.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(35,1,16,'0','We cannot just assert that the fully leveled down world (Z) is obviously worse than any other world. The consequentialist seems to have a coherent argument that the leveled down world contains vastly more good than the first world. Thus just saying ?But Z is bad? and leaving at that expresses an opinion. But it is not something the consequentialist (or the rest of us) should take seriously. You did not give a good independent reason for thinking that there is something extremely deficient about the leveled down world. This is why we discussed things like the disrespect of desert, or the diminished future goods from economic factors, et cetera. Those have the potential for showing that the consequentialist theory is a bad theory because it commits her to a serious mistake. This was exactly the sort of question where every little step in the argument matters. It is easy to state the basic idea. But the details are what make or break an answer. Remember, part of the point of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a very unnatural and very difficult way of thinking. But it is crucial that, at least for the purposes of the next exam, you try to force yourself to think like this.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(36,1,16,'1','It was not clear from your discussion that you understood that we cannot just assert that the fully leveled down world (Z) is obviously worse than any other world. The consequentialist seems to have a coherent argument that the leveled down world contains vastly more good than the first world. Thus just saying ?But Z is bad? and leaving at that expresses an opinion. But it is not something the consequentialist (or the rest of us) should take seriously. You left out too many details of the argument for it to be clear why what you were saying was a strong independent reason for thinking that there is something extremely deficient about the leveled down world. That hampered your ability to make the charge that the consequentialist theory is a bad theory because it commits her to a serious mistake. This was exactly the sort of question where every little step in the argument matters. It is easy to state the basic idea. But the details are what make or break an answer. Remember, part of the point of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a very unnatural and very difficult way of thinking. But it is crucial that, at least for the purposes of the next exam, you try to force yourself to think like this.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(37,1,16,'2','Your discussion made it pretty clear that you understood that we cannot just assert that the fully leveled down world (Z) is obviously worse than any other world. The consequentialist seems to have a coherent argument that the leveled down world contains vastly more good than the first world. Thus just saying ?But Z is bad? and leaving at that expresses an opinion. But it is not something the consequentialist (or the rest of us) should take seriously. While you were not always completely clear on the details of the argument, you gave a good independent reason for thinking that there is something extremely deficient about the leveled down world. That allowed you to make the charge that the consequentialist theory is a bad theory because it commits her to a serious mistake. While I think the answer could have been stronger here. You did a good job. That is important because this was exactly the sort of question where every little step in the argument matters. It is easy to state the basic idea. But the details are what make or break an answer. Remember, part of the point of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a very unnatural and very difficult way of thinking. You seem to have a pretty good grasp on this. Please make sure you do not forget about it on the next exam (or in choosing a major [I know, I?m shameless. But that doesn?t make it less true.].','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(38,1,16,'3','As was clear from your discussion, we cannot just assert that the fully leveled down world (Z) is obviously worse than any other world. The consequentialist seems to have a coherent argument that the leveled down world contains vastly more good than the first world. Thus just saying ?But Z is bad? and leaving at that expresses an opinion. But it is not something the consequentialist (or the rest of us) should take seriously. You gave us an What you gave was a solid independent reason for thinking that there is something extremely deficient about the leveled down world. That had the potential to show that the consequentialist theory is a bad theory because it commits her to a serious mistake. And you clearly understood that. That is important because this was exactly the sort of question where every little step in the argument matters. It is easy to state the basic idea. But the details are what make or break an answer. One of the points of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a unnatural and difficult way of thinking. Yet, you really have the hang of it. If you aren?t a philosophy major on the outside, there?s a good one lurking on the inside (shameless plug, I know. But true).','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(39,1,17,'0','Your discussion left out the crucial discussion of what the consequentialist/Singer means by \'diminishing marginal utility\'. I think a reader would have had difficulty understanding how it could prevent the consequentialist from being committed to saying that the completely leveled down word is the ideal distributive state. I think it was not clear that many of the objections to the claim that the leveled down world (Z) is ideal assume that things would have better with some inequality. But most consequentialists do not think equality is countable good. Thus they can just agree that the better off group should stop giving when that ceases to make things better. Since you left out or completely rushed past several of the steps in this reasoning, I think someone would not have been able to see why the objection turns out not to be a problem after all.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(40,1,17,'1','Your discussion did not do enough to explain what the consequentialist/Singer means by \'diminishing marginal utility\'. I think a reader would have had difficulty understanding how it could prevent the consequentialist from being committed to saying that the completely leveled down word is the ideal distributive state. I think it was not clear that many of the objections to the claim that the leveled down world (Z) is ideal assume that things would have better with some inequality. But most consequentialists do not think equality is countable good. Thus they can just agree that the better off group should stop giving when that ceases to make things better. Since several of the steps in this reasoning were rushed or unclear, I think someone would have a lot of trouble seeing why the objection turns out not to be a problem after all.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(41,1,17,'2','You did a good job in explaining what the consequentialist/Singer means by \'diminishing marginal utility\'. I think you made it easy for the reader to understand how it could prevent the consequentialist from being committed to saying that the completely leveled down word is the ideal distributive state. Though your explanation was a bit murky in places, I think a reader would be able to see that many of the objections to the claim that the leveled down world (Z) is ideal assume that things would have better with some inequality. But most consequentialists do not think equality is countable good. Thus they can just agree that the better off group should stop giving when that ceases to make things better. Some of the steps in this reasoning were a bit rushed or unclear, but, again, I think someone could see why the objection turns out not to be a problem after all.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(42,1,17,'3','You did an excellent job in explaining what the consequentialist/Singer means by \'diminishing marginal utility\'. I think you made it easy for the reader to understand how it could prevent the consequentialist from being committed to saying that the completely leveled down word is the ideal distributive state. You made it clear that many of the objections to the claim that the leveled down world (Z) is ideal assume that things would have better with some inequality. But most consequentialists do not think equality is countable good. Thus they can just agree that the better off group should stop giving when that ceases to make things better. So, from your discussion, I think someone could see why the objection turns out not to be a problem after all. ','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(43,1,18,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(44,1,18,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(45,1,18,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(46,1,18,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(47,1,19,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(48,1,19,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(49,1,19,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(50,1,19,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(51,1,20,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(52,1,20,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(53,1,20,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(54,1,20,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(55,1,21,'0','The standard for completeness on all these answers is roughly that an intelligent undergraduate such as yourself who has not had the pleasure of taking this class should be able to read the answer and understand the issue at hand and what you have to say about it. Since this question was about a fundamental part of consequentialism, it was important to give a (possibly very) brief sketch of what consequentialists hold. I do not think that someone like this would have gotten a sufficient understanding from what you said. Because you did not really say anything about it, they probably would have been totally puzzled by some key features of the problem (for example, why the conception of the right in terms of the good would force a person to always see more lives saved as better in the cases under discussion). This will be something to keep in mind for the next exam. Fortunately, you can avoid this problem pretty easily if you just try explaining your answer to a friend. As soon as you start talking about what the consequentialist thinks, they will probably stop you and ask what makes someone a consequentialist.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(56,1,21,'1','The standard for completeness on all these answers is roughly that an intelligent undergraduate such as yourself who has not had the pleasure of taking this class should be able to read the answer and understand the issue at hand and what you have to say about it. Since this question was about a fundamental part of consequentialism, it was important to give a (possibly very) brief sketch of what consequentialists hold. I do not think that someone like this would have gotten a sufficient understanding from what you said. Without a much fuller discussion of some of the details from you, they might have not been totally clear on some key features of the view (for example, why the conception of the right in terms of the good would force a person to always see more lives saved as better in the cases under discussion). This will be something to keep in mind for the next exam. Fortunately, you can avoid this problem pretty easily if you just try explaining your answer to a friend. As soon as you start talking about what the consequentialist thinks, they will probably stop you and ask what makes someone a consequentialist.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(57,1,21,'2','The standard for completeness on all these answers is roughly that an intelligent undergraduate such as yourself who has not had the pleasure of taking this class should be able to read the answer and understand the issue at hand and what you have to say about it. Since this question was about a fundamental part of consequentialism, it was important to give a (possibly very) brief sketch of what consequentialists hold. I think someone like this would have gotten a sufficient understanding from what you said. Though they might have not been totally clear on some of the details (for example, why the conception of the right in terms of the good would force a person to always see more lives saved as better in the cases under discussion).','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(58,1,21,'3','You did a good job giving a quick overview of the relevant parts of the consequentialist picture. I think an intelligent undergraduate such as yourself who has not had the pleasure of taking this class should be able to read the answer and understand the issue at hand and what you have to say about it. ','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(59,1,22,'0','You needed to give an example in which a consequentialist theory requires an action that raises the demandingness objection. You did not give an example of this phenomenon. This probably hurt your answer a great deal. The issue is very difficult. And it is virtually impossible if you do not have a good example to work off of. On the next exam, make sure you have a central example for each of the questions. And then run it by me to make sure it is a crystal clear case of the phenomenon at issue.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(60,1,22,'1','The example you gave in which a consequentialist theory requires an action that raises the demandingness objection was in the ballpark. But it was not really the best example for motivating the discussion you gave. Indeed, it may have led you astray in the discussion. On the next exam, make sure you have a central example for each of the questions. And then run it by me to make sure it is a crystal clear case of the phenomenon at issue.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(61,1,22,'2','The example you gave in which a consequentialist theory requires an action that raises the demandingness objection was okay as a general example. But it might have helped your answer if you had tailored the example better or said a bit more to describe it. ','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(62,1,22,'3','The example you gave in which a consequentialist theory requires an action that raises the demandingness objection was perfect for the discussion you gave.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(63,1,23,'0','The question required you to identify which part of the consequentialist theory raises the problem. The most likely candidate is the particularly strict conception of impartiality it involves. Unfortunately, you failed to explain how impartiality requires giving other people?s interests and your own interests equal weight. Your answer did not at all show that impartiality, in this sense, is not merely a matter of putting aside your feelings or emotions. If you did that, you would not be acting impartially. You would be treating your interests as less important than others. That is not what the consequentialist is claiming. This was exactly the sort of question where it is easy to get the basic idea. But where the details can trip you up in answering the question. That is what I worry happened here. Remember, part of the point of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a very unnatural and very difficult way of thinking. But it is crucial that, at least for the purposes of the next exam, you try to force yourself to think like this.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(64,1,23,'1','The question required you to identify which part of the consequentialist theory raises the problem. The most likely candidate is the particularly strict conception of impartiality it involves. You did a great job of setting out how impartiality requires giving other people?s interests and your own interests equal weight. It was clear from your answer that impartiality, in this sense, is not merely a matter of putting aside your feelings or emotions. If you did that, you would not be acting impartially. You would be treating your interests as less important than others. That is not what the consequentialist is claiming. This was exactly the sort of question where it is easy to get the basic idea, but where the details can trip you up in answering the question. Unfortunately, I think your answer fell into this trap. Remember, part of the point of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a very unnatural and very difficult way of thinking. But it is crucial that, at least for the purposes of the next exam, you try to force yourself to think like this.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(65,1,23,'2','The question required you to identify which part of the consequentialist theory raises the problem. The most likely candidate is the particularly strict conception of impartiality it involves. You did a great job of setting out how impartiality requires giving other people?s interests and your own interests equal weight. It was clear from your answer that impartiality, in this sense, is not merely a matter of putting aside your feelings or emotions. If you did that, you would not be acting impartially. You would be treating your interests as less important than others. That is not what the consequentialist is claiming. And you clearly understood that. This was exactly the sort of question where it is easy to get the basic idea, but where the details can trip you up in answering the question. So congratulations on avoiding this tripwire. One of the points of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a unnatural and difficult way of thinking. Yet, you really have the hang of it. If you aren?t a philosophy major on the outside, there?s a good one lurking on the inside (shameless plug, I know. But true).','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(66,1,23,'3','The question required you to identify which part of the consequentialist theory raises the problem. The most likely candidate is the particularly strict conception of impartiality it involves. You did a decent job of setting out how impartiality requires giving other people?s interests and your own interests equal weight. Your answer made it pretty clear that impartiality, in this sense, is not merely a matter of putting aside your feelings or emotions. If you did that, you would not be acting impartially. You would be treating your interests as less important than others. That is not what the consequentialist is claiming. I think your discussion could have been stronger in places. But the weaknesses probably did not lead you into trouble on other parts of the answer. This was exactly the sort of question where it is easy to get the basic idea, but where the details can trip you up in answering the question. Remember, part of the point of this class is to get you to see that many arguments or assumptions which seem obvious can turn out to be confusing or even clearly false once you start thinking about the details. This is a very unnatural and very difficult way of thinking. You seem to have a pretty good grasp on this. Please make sure you do not forget about it on the next exam (or in choosing a major [I know, I?m shameless. But that doesn?t make it less true.].','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(67,1,24,'0','Many philosophical discussions, amongst professionals or otherwise, go wrong because they set up the problem in the wrong way. I think you ran into a lot of trouble here. You did not develop a strong way of approaching the problem. That means you started off the answer by digging yourself a hole that was hard to get back out of. Though it could have been stronger. For what it is worth, I think one of the strongest ways of framing the problem is in terms of the axiom that ?ought implies can? (of course, others disagree). That is, by appealing to the widely agreed upon idea that it does not make sense to say that a person should/must/ought do something if it is in the relevant sense impossible for them to do it. If you do this, then the rest of the answer can just be focused on what counts as impossible. That makes an extraordinarily difficult question ?I think it is one of the five hardest in philosophy? a bit easier to get a handle on. In any event, I suspect that the way you framed and approached the problem led to some of the other problems with your answer.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(68,1,24,'1','Many philosophical discussions, amongst professionals or otherwise, go wrong because they set up the problem in the wrong way. I think you ran into trouble here. You did not develop a strong way of approaching the problem. That means you started off the answer by digging yourself a hole that was hard to get back out of. For what it is worth, I think one of the strongest ways of framing the problem is in terms of the axiom that ?ought implies can? (of course, others disagree). That is, by appealing to the widely agreed upon idea that it does not make sense to say that a person should/must/ought do something if it is in the relevant sense impossible for them to do it. If you do this, then the rest of the answer can just be focused on what counts as impossible. That makes an extraordinarily difficult question ?I think it is one of the five hardest in philosophy? a bit easier to get a handle on. In any event, I suspect that the way you framed and approached the problem led to some of the other problems with your answer.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(69,1,24,'2','Many philosophical discussions, amongst professionals or otherwise, go wrong because they set up the problem in the wrong way. I think your approach to the answer was decent. Though it could have been stronger. For what it is worth, I think one of the strongest ways of framing the problem is in terms of the axiom that ?ought implies can? (of course, others disagree). That is, by appealing to the widely agreed upon idea that it does not make sense to say that a person should/must/ought do something if it is in the relevant sense impossible for them to do it. If you do this, then the rest of the answer can just be focused on what counts as impossible. That makes an extraordinarily difficult question ?I think it is one of the five hardest in philosophy? a bit easier to get a handle on. In any event, the way you framed and approached the problem was okay and was not really an underlying problem with your answer.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(70,1,24,'3','Many philosophical discussions, amongst professionals or otherwise, go wrong because they set up the problem in the wrong way. Your approach to the issue here was an excellent one. For what it is worth, I think one of the strongest ways of framing the problem is in terms of the axiom that ?ought implies can? (of course, others disagree). That is, by appealing to the widely agreed upon idea that it does not make sense to say that a person should/must/ought do something if it is in the relevant sense impossible for them to do it. If you do this, then the rest of the answer can just be focused on what counts as impossible. That makes an extraordinarily difficult question ?I think it is one of the five hardest in philosophy? a bit easier to get a handle on. In any event, you did a great job framing and approaching the problem.  ','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(71,1,25,'0','The question required you to consider what the consequentialist might say in response to the objection once you have formulated it as powerfully as possible. I suppose that basically ?I disagree? without further argument is technically a response. But, as with everything in the class, you want to address the best possible objection in the best possible way.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(72,1,25,'1','The question required you to consider what the consequentialist might say in response to the objection once you have formulated it as powerfully as possible. I suppose that basically ?I disagree? without further argument is technically a response. But, as with everything in the class, you want to address the best possible objection in the best possible way.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(73,1,25,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(74,1,25,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(75,1,26,'0','The problem of consequentialism being too demanding runs much deeper than a simple disagreement about what a person should do in a difficult situation. The consequentialist?s conclusions cannot be answered by simply asserting that people are incapable of the impartiality. For one, there are plenty of real cases in which people sacrifice extremely important things ?sometimes their lives? for complete strangers. I think you fell into this trap. The way you discussed the difficulty of impartiality made it too easy for the consequentialist to get around. Thus it was hard to see why what you discussed deserved any serious response. That undermined your ability to engage in the deep discussion the question required.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(76,1,26,'1','The problem of consequentialism being too demanding runs much deeper than a simple disagreement about what a person should do in a difficult situation. The consequentialist?s conclusions cannot be answered by simply asserting that people are incapable of the impartiality. For one, there are plenty of real cases in which people sacrifice extremely important things ?sometimes their lives? for complete strangers. You avoided this trap to some extent. But the way in which you discussed the difficulty of impartiality made it harder for you to engage in the deep discussion the question required.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(77,1,26,'2','You correctly understood that the problem runs much deeper than a simple disagreement about what a person should do in a hard situation. You avoided the trap of thinking that the consequentialist?s conclusions can be answered by simply asserting that people are incapable impartiality. For one, there are plenty of real cases in which people sacrifice extremely important things ?sometimes their lives? for complete strangers. Thus you did not make the problem easy for the consequentialist to get around. That opened the way for the deep discussion the question required.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(78,1,26,'3','You correctly understood that the problem runs much deeper than a simple disagreement about what a person should do in a hard situation. You avoided the trap of thinking that the consequentialist?s conclusions can be answered by simply asserting that people are incapable impartiality. For one, there are plenty of real cases in which people sacrifice extremely important things ?sometimes their lives? for complete strangers. Thus you did not make the problem easy for the consequentialist to get around. That opened the way for the deep discussion the question required.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(79,1,27,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(80,1,27,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(81,1,27,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(82,1,27,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(83,1,28,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(84,1,28,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(85,1,28,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(86,1,28,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(87,1,29,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(88,1,29,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(89,1,29,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(90,1,29,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(92,1,10,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(93,1,10,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(94,1,10,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(95,1,10,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(96,1,11,'0','We have a powerful natural tendency to think as though distance matters morally. We don\'t feel the same urgency and sympathy when we learn of someone who needs help on another continent as we do if they are right in front of us. It is not enough to just say that we should ignore this tendency. We need an argument to show demonstrate that it is a mistake. Your answer did not provide the needed argument. Someone reading your answer would have little idea why they should think that distance does not matter.\rYou needed to say something like the following: A common methodology in ethics for determining whether some fact affects our moral obligations (whether it matters morally) to use the contrasting cases method: Start with one case where we have clear beliefs about what should be done. Then imagine a series of cases where we change only one variable. If at the end of the series, we have the same beliefs about what should be done, then the variable did not matter morally.\rThe example we used in class was a baby drowning in a puddle. We are completely certain that someone standing right next to the baby should save it; if they don\'t they are a horrible person. We then imagined some technology (the Baby Flipper 5000) which allows us to change the distance while holding constant the rescuer\'s ability to know that the child needs help and her ability to help. We increase the physical distance until the baby (with Baby Flipper standing by) is in Mongolia. Since we agree that the rescuer is exactly as required to save the baby in Mongolia via the Baby Flipper app as she was when the baby was right in front of her, we conclude that distance is not a moral consideration. That is, distance does not matter morally.\r','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(97,1,11,'1','We have a powerful natural tendency to think as though distance matters morally. We don\'t feel the same urgency and sympathy when we learn of someone who needs help on another continent as we do if they are right in front of us. It is not enough to just say that we should ignore this tendency. We need an argument to show demonstrate that it is a mistake. Your answer did not provide the needed argument. Someone reading your answer would have little idea why they should think that distance does not matter.\rYou needed to say something like the following: A common methodology in ethics for determining whether some fact affects our moral obligations (whether it matters morally) to use the contrasting cases method: Start with one case where we have clear beliefs about what should be done. Then imagine a series of cases where we change only one variable. If at the end of the series, we have the same beliefs about what should be done, then the variable did not matter morally.\rThe example we used in class was a baby drowning in a puddle. We are completely certain that someone standing right next to the baby should save it; if they don\'t they are a horrible person. We then imagined some technology (the Baby Flipper 5000) which allows us to change the distance while holding constant the rescuer\'s ability to know that the child needs help and her ability to help. We increase the physical distance until the baby (with Baby Flipper standing by) is in Mongolia. Since we agree that the rescuer is exactly as required to save the baby in Mongolia via the Baby Flipper app as she was when the baby was right in front of her, we conclude that distance is not a moral consideration. That is, distance does not matter morally.\r','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(98,1,11,'2','We have a powerful natural tendency to think as though distance matters morally. We don\'t feel the same urgency and sympathy when we learn of someone who needs help on another continent as we do if they are right in front of us. It is not enough to just say that we should ignore this tendency. We need an argument to show demonstrate that it is a mistake. Your answer sketched some of the needed argument, but not in enough detail. I do not think that someone reading your answer would be convinced that distance does not matter.\rA fuller explanation would have said something like the following: A common methodology in ethics for determining whether some fact affects our moral obligations (whether it matters morally) to use the contrasting cases method: Start with one case where we have clear beliefs about what should be done. Then imagine a series of cases where we change only one variable. If at the end of the series, we have the same beliefs about what should be done, then the variable did not matter morally.\rThe example we used in class was a baby drowning in a puddle. We are completely certain that someone standing right next to the baby should save it; if they don?t they are a horrible person. We then imagined some technology (the Baby Flipper 5000) which allows us to change the distance while holding constant the rescuer\'s ability to know that the child needs help and her ability to help. We increase the physical distance until the baby (with Baby Flipper standing by) is in Mongolia. Since we agree that the rescuer is exactly as required to save the baby in Mongolia via the Baby Flipper app as she was when the baby was right in front of her, we conclude that distance is not a moral consideration. That is, distance does not matter morally.\r','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(99,1,11,'3','We have a powerful natural tendency to think as though distance matters morally. We don\'t feel the same urgency and sympathy when we learn of someone who needs help on another continent as we do if they are right in front of us. It is not enough to just say that we should ignore this tendency. We need an argument to show demonstrate that it is a mistake. You recognized that and did a good job setting out the needed argument. I think that someone reading your answer would be convinced that distance does not matter.\rYou did a great job on this part. But you may have been a bit weak on some points (which is understandable on a timed exam). So, for the record, here is pretty much everything that needed to be said: \rA common methodology in ethics for determining whether some fact affects our moral obligations (whether it matters morally) to use the contrasting cases method: Start with one case where we have clear beliefs about what should be done. Then imagine a series of cases where we change only one variable. If at the end of the series, we have the same beliefs about what should be done, then the variable did not matter morally.\rThe example we used in class was a baby drowning in a puddle. We are completely certain that someone standing right next to the baby should save it; if they don?t they are a horrible person. We then imagined some technology (the Baby Flipper 5000) which allows us to change the distance while holding constant the rescuer\'s ability to know that the child needs help and her ability to help. We increase the physical distance until the baby (with Baby Flipper standing by) is in Mongolia. Since we agree that the rescuer is exactly as required to save the baby in Mongolia via the Baby Flipper app as she was when the baby was right in front of her, we conclude that distance is not a moral consideration. That is, distance does not matter morally.\r','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(100,1,12,'0','Singer\'s argument showed that our natural tendency to not feel motivated to help strangers who are far away is not a good guide to what we should do. \rBut your answer creates the impression that distance does not matter at all.  That is not true. Distance matters practically. That is, it affects our abilities to know when someone needs help, how to help, and the ways in which we can help. For example, if someone is drowning in a lake in Mongolia, the distance means that someone in California is unlikely to know that they need help and unlikely to be able to provide help in time. But if one is equally able to help someone nearby and someone on the other side of the world, she should probably flip a coin.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(101,1,12,'1','Singer\'s argument showed that our natural tendency to not feel motivated to help strangers who are far away is not a good guides to what we should do. \rBut that doesn\'t mean that distance is completely irrelevant. It matters practically. That is, it affects our abilities to know when someone needs help, how to help, and the ways in which we can help. This was not entirely clear from your discussion. You needed to make this point explicitly. In addition to stating the claim, it is very helpful to give an example. You might have mentioned, for example, if someone is drowning in a lake in Mongolia, the distance means that someone in California is unlikely to know that they need help and unlikely to be able to provide help in time. But if one is equally able to help someone nearby and someone on the other side of the world, she should probably flip a coin.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(102,1,12,'2','Singer\'s argument showed that our natural tendency to not feel motivated to help strangers who are far away is not a good guides to what we should do. \rBut that doesn\'t mean that distance is completely irrelevant. It matters practically. That is, it affects our abilities to know when someone needs help, how to help, and the ways in which we can help. This was not entirely clear from your discussion. You needed to make this point explicitly. In addition to stating the claim, it is very helpful to give an example. You might have mentioned, for example, if someone is drowning in a lake in Mongolia, the distance means that someone in California is unlikely to know that they need help and unlikely to be able to provide help in time. But if one is equally able to help someone nearby and someone on the other side of the world, she should probably flip a coin.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(103,1,12,'3','Singer\'s argument showed that our natural tendency to not feel motivated to help strangers who are far away is not a good guide to what we should do. \rAs your answer made clear, that doesn\'t mean that distance is completely irrelevant. It matters practically. It was clear to me that you understood that distance affects our abilities to know when someone needs help, how to help, and the ways in which we can help. For example, if someone is drowning in a lake in Mongolia, the distance means that someone in California is unlikely to know that they need help and unlikely to be able to provide help in time. But if one is equally able to help someone nearby and someone on the other side of the world, she should probably flip a coin.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(104,1,13,'0','Your answer did not acknowledge that the number of rescuers can, of course, matter practically. The number of people (and their skills) may affect what someone should do. You needed to show the reader that, for example, if there are several trained rescuers, it might be best for you to stay out of the way. Whereas, if you were alone, you should help.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(105,1,13,'1','Your answer did not acknowledge that the number of rescuers can, of course, matter practically. The number of people (and their skills) may affect what someone should do. You needed to show the reader that, for example, if there are several trained rescuers, it might be best for you to stay out of the way. Whereas, if you were alone, you should help.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(106,1,13,'2','Your answer did a bit to show that the number of rescuers can, of course, matter practically. But you needed to do more to make the point that the number of people (and their skills) may affect what someone should do. I do not think a reader would have been able to see that, for example, if there are several trained rescuers, it might be best for you to stay out of the way. Whereas, if you were alone, you should help.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(107,1,13,'3','It was clear from your answer that the number of rescuers can, of course, matter practically. The number of people (and their skills) may affect what someone should do. I am sure that a reader would have been able to see that, for example, if there are several trained rescuers, it might be best for you to stay out of the way. Whereas, if you were alone, you should help.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(109,1,7,'3','Any abstract discussion needs at least one concrete example. In distinguishing between genuine tragedies of the commons and other kinds of situations, the details can be very important. You did an excellent job here. Your example cleanly distinguished tragedies of the commons from ordinary cases in which, for example, many small harms add up, or where widespread irresponsibility or selfishness harm everyone.','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(110,1,8,'0',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(112,1,8,'1',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(113,1,8,'2',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(114,1,8,'3',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table element_assignments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `element_assignments`;

CREATE TABLE `element_assignments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_assignment_id` int(10) unsigned NOT NULL,
  `element_id` int(10) unsigned NOT NULL,
  `subtask` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `el_assign_unique` (`question_assignment_id`,`subtask`),
  KEY `element_assignments_element_id_foreign` (`element_id`),
  CONSTRAINT `element_assignments_element_id_foreign` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `element_assignments_question_assignment_id_foreign` FOREIGN KEY (`question_assignment_id`) REFERENCES `question_assignments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `element_assignments` WRITE;
/*!40000 ALTER TABLE `element_assignments` DISABLE KEYS */;

INSERT INTO `element_assignments` (`id`, `question_assignment_id`, `element_id`, `subtask`, `created_at`, `updated_at`)
VALUES
	(1,1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,3,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,4,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,2,5,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,2,6,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,2,7,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,2,8,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,3,15,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,3,16,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,3,17,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,3,18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,3,19,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(17,3,20,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,4,21,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(19,4,22,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,4,23,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,4,24,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,4,25,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,4,26,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,5,27,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(25,5,28,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(26,5,29,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(29,6,10,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(30,6,11,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(31,6,12,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(33,6,13,4,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `element_assignments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table element_scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `element_scores`;

CREATE TABLE `element_scores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `element_assignment_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `score` double(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `elassign_unique` (`element_assignment_id`,`student_id`),
  KEY `element_scores_student_id_foreign` (`student_id`),
  CONSTRAINT `element_scores_element_assignment_id_foreign` FOREIGN KEY (`element_assignment_id`) REFERENCES `element_assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `element_scores_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `element_scores` WRITE;
/*!40000 ALTER TABLE `element_scores` DISABLE KEYS */;

INSERT INTO `element_scores` (`id`, `element_assignment_id`, `student_id`, `score`, `created_at`, `updated_at`)
VALUES
	(1,1,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,2,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,3,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,4,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,6,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,7,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,9,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,10,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,11,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,12,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,13,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,14,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(16,15,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,17,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,18,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,19,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,20,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,21,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,22,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(25,23,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(26,24,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(27,25,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(28,26,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(32,29,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(33,30,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(34,31,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(36,33,1,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(37,1,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(38,2,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(39,3,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(40,4,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(41,6,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(42,7,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(43,9,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(44,10,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(45,11,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(46,12,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(47,13,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(48,14,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(49,15,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(50,17,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(51,18,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(52,19,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(53,20,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(54,21,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(55,22,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(56,23,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(57,24,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(58,25,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(59,26,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(60,29,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(61,30,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(62,31,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(63,33,2,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(64,1,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(65,2,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(66,3,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(67,4,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(68,6,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(69,7,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(70,9,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(71,10,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(72,11,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(73,12,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(74,13,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(75,14,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(76,15,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(77,17,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(78,18,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(79,19,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(80,20,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(81,21,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(82,22,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(83,23,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(84,24,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(85,25,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(86,26,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(87,29,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(88,30,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(89,31,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(90,33,3,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(91,1,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(92,2,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(93,3,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(94,4,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(95,6,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(96,7,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(97,9,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(98,10,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(99,11,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(100,12,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(101,13,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(102,14,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(103,15,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(104,17,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(105,18,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(106,19,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(107,20,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(108,21,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(109,22,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(110,23,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(111,24,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(112,25,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(113,26,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(114,29,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(115,30,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(116,31,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(117,33,4,2.30,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `element_scores` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table elements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `elements`;

CREATE TABLE `elements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `elementName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displayText` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentText` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `elements_user_id_foreign` (`user_id`),
  CONSTRAINT `elements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `elements` WRITE;
/*!40000 ALTER TABLE `elements` DISABLE KEYS */;

INSERT INTO `elements` (`id`, `user_id`, `elementName`, `displayText`, `commentText`, `created_at`, `updated_at`)
VALUES
	(1,1,'Moral hazard structure','','Explanation of overall structure of a moral hazard','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,'Reducing risk','','Explanation of how a moral hazard involves reducing risk','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,'Moral hazard example','','Example of a moral hazard','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,'Unintended consequence','','Does not characterize moral hazard as a mere unintended consequence','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,1,'Payoff structure','','Explanation of the payoff structure and thresholds in a toc','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,1,'Strict dominance','','Explanation of strict dominance of cheating','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,1,'TOC example','','Example of a tragedy of the commons','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,1,'Forced change','','Explanation of why the only way out is a forced change in payoff structure','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,1,'Explain moral significance','','Explanation of the concept of moral significance','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,1,'singer_overview','','Presentation of a brief overview of Singer\'s argument','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,1,'singer_location_argument','','Setting out Singer\'s argument that distance per se can\'t matter morally','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,1,'singer_location_can_matter','','Explanation of when and in what ways distance can matter morally','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,1,'singer_rescuers_argu','','Explanation of Singer\'s argument that number of rescuers can\'t matter morally','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,1,'num_rescuers_matter','','Explains how number of rescuers can matter','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,1,'Leveling down seems ideal','','Explanation of why consequentialists seem committed to LDS being ideal','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(16,1,'Objection to leveling down','','Presentation of an objection to the LDS being ideal','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(17,1,'Role of diminishing marginal utility','','Explanation of how diminishing marginal utility helps Singer avoid commitment to LDS','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,1,'Role of comparable moral significance','','Explanation of how comparable moral significance helps Singer avoid commitment to the LDS being ideal','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(19,1,'Singer consequentialist','','Exploration of whether Singer is completely consequentialist','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,1,'Leveling down not forced','','Does not make LDS depend on involuntary contributions','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,1,'Consequentialism overview','','Brief overview of consequentialism','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,1,'Example of demandingness','','Example where consequentialism is too demanding','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,1,'Identify impartiality','','Identification of impartiality as the source of the worry','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,1,'Focus on ought implies can','','Discussion conducted in terms of ought implies can','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(25,1,'Reply to demanding objection','','The consequentialist reply to the fully developed problem','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(26,1,'Depth of problem','','The problem is not framed as a brute disagreement or complete impossibility of impartiality','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(27,1,'Explain moral significance','','Explanation of the concept of moral significance','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(28,1,'Moral significance potential problem','','Explains how moral sig could be problematic','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(29,1,'Response to moral significance problem','','Explains how Singer could solve the problem with moral sig','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `elements` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exam_kumi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exam_kumi`;

CREATE TABLE `exam_kumi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) unsigned NOT NULL,
  `kumi_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `exam_kumi_exam_id_foreign` (`exam_id`),
  KEY `exam_kumi_kumi_id_foreign` (`kumi_id`),
  CONSTRAINT `exam_kumi_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_kumi_kumi_id_foreign` FOREIGN KEY (`kumi_id`) REFERENCES `kumis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `exam_kumi` WRITE;
/*!40000 ALTER TABLE `exam_kumi` DISABLE KEYS */;

INSERT INTO `exam_kumi` (`id`, `exam_id`, `kumi_id`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `exam_kumi` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exams`;

CREATE TABLE `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `released` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `exams_user_id_term_name_year_unique` (`user_id`,`term`,`name`,`year`),
  CONSTRAINT `exams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;

INSERT INTO `exams` (`id`, `user_id`, `term`, `year`, `name`, `locked`, `released`, `created_at`, `updated_at`)
VALUES
	(1,1,'Fall',2015,'Global poverty',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `access_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`access_key`),
  KEY `feedback_access_key_index` (`access_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table kumi_student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kumi_student`;

CREATE TABLE `kumi_student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kumi_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `kumi_student_kumi_id_foreign` (`kumi_id`),
  KEY `kumi_student_student_id_foreign` (`student_id`),
  CONSTRAINT `kumi_student_kumi_id_foreign` FOREIGN KEY (`kumi_id`) REFERENCES `kumis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kumi_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `kumi_student` WRITE;
/*!40000 ALTER TABLE `kumi_student` DISABLE KEYS */;

INSERT INTO `kumi_student` (`id`, `kumi_id`, `student_id`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,4,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `kumi_student` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kumis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kumis`;

CREATE TABLE `kumis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `year` int(11) NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kumis_user_id_year_nickname_unique` (`user_id`,`year`,`nickname`),
  CONSTRAINT `kumis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `kumis` WRITE;
/*!40000 ALTER TABLE `kumis` DISABLE KEYS */;

INSERT INTO `kumis` (`id`, `user_id`, `year`, `nickname`, `created_at`, `updated_at`)
VALUES
	(1,1,2015,'classname','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `kumis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_10_12_000000_create_users_table',1),
	('2014_10_12_100000_create_password_resets_table',1),
	('2015_07_17_172134_create_exams_table',1),
	('2015_07_17_172445_create_questions_table',1),
	('2015_07_17_172458_create_elements_table',1),
	('2015_07_17_173232_create_students_table',1),
	('2015_07_17_173233_create_question_assignment_table',1),
	('2015_07_17_173234_create_element__assignment_table',1),
	('2015_07_17_173620_create_element_scores_table',1),
	('2015_07_17_173638_create_question_scores_table',1),
	('2015_07_18_120935_create_kumis_table',1),
	('2015_07_18_121931_create_kumi_student_table',1),
	('2015_07_18_121949_create_exam_kumi_table',1),
	('2015_07_22_152434_create_comments_table',1),
	('2015_07_31_172413_create_jobs_table',1),
	('2015_08_02_134402_access_keys',1),
	('2015_08_02_155906_feedback',1),
	('2015_08_04_120147_stored_procedures',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table question_assignments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_assignments`;

CREATE TABLE `question_assignments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `question_number` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_assignments_exam_id_question_number_unique` (`exam_id`,`question_number`),
  KEY `question_assignments_question_id_foreign` (`question_id`),
  CONSTRAINT `question_assignments_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_assignments_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `question_assignments` WRITE;
/*!40000 ALTER TABLE `question_assignments` DISABLE KEYS */;

INSERT INTO `question_assignments` (`id`, `exam_id`, `question_id`, `question_number`, `created_at`, `updated_at`)
VALUES
	(1,1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,3,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,4,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,1,5,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,1,6,6,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `question_assignments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table question_scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_scores`;

CREATE TABLE `question_scores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_assignment_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `score` double(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_scores_question_assignment_id_student_id_unique` (`question_assignment_id`,`student_id`),
  KEY `question_scores_question_assignment_id_index` (`question_assignment_id`),
  KEY `question_scores_student_id_index` (`student_id`),
  CONSTRAINT `question_scores_question_assignment_id_foreign` FOREIGN KEY (`question_assignment_id`) REFERENCES `question_assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_scores_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `question_scores` WRITE;
/*!40000 ALTER TABLE `question_scores` DISABLE KEYS */;

INSERT INTO `question_scores` (`id`, `question_assignment_id`, `student_id`, `score`, `created_at`, `updated_at`)
VALUES
	(1,1,1,5.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,2,6.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,3,2.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,4,2.20,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,2,1,5.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,2,2,6.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,2,3,2.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,2,4,2.20,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,3,1,5.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,3,2,6.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,3,3,2.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(12,3,4,2.20,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,4,1,5.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,4,2,6.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(15,4,3,2.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(16,4,4,2.20,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(17,5,1,5.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(18,5,2,6.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(19,5,3,2.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(20,5,4,2.20,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(21,6,1,5.30,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(22,6,2,6.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(23,6,3,2.00,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(24,6,4,2.20,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `question_scores` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `questionName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `questionText` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `questions_user_id_foreign` (`user_id`),
  CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`id`, `user_id`, `questionName`, `questionText`, `created_at`, `updated_at`)
VALUES
	(1,1,'Moral Hazard','Explain the concept of a moral hazard. The way you describe it must be directly relevant to Hardin&#39;s argument. (For example, it&#39;s not easy to see how Wikipedia&#39;s description of information asymmetry is what&#39;s going on in Hardin&#39;s argument.)','0000-00-00 00:00:00','2015-08-04 15:52:06'),
	(2,1,'Tragedy of the Commons','Using the example of overfishing, explain the concept of a tragedy of the commons.','0000-00-00 00:00:00','2015-08-04 15:52:06'),
	(3,1,'Leveling Down','Explain the leveling down argument and why many find it to be objectionable. (You may add a short critique if you want, but don&#39;t get distracted). Then explain why Singer&#39;s argument doesn&#39;t commit him to the leveled down world being the ideal distribution of resources. Explain whether these features of his argument are consistent with a completely consequentialist approach to global poverty.','0000-00-00 00:00:00','2015-08-04 15:52:06'),
	(4,1,'Too Demanding Objection','Explain the objection that consequentialism is too demanding. Be sure to explain which of the four elements of consequentialist theories creates this alleged problem. What could the consequentialist say in reply?','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,1,'Problems with Moral Significance','Why might the claim that we are only obligated to give things with no moral significance be problematic from a consequentialist perspective? Is there a way of understanding this claim that avoids this problem? [Make sure you explain what &#39;no moral significance means&#39;. The same goes for &#39;comparable moral significance&#39; if you bring it up.]','0000-00-00 00:00:00','2015-08-04 15:52:06'),
	(6,1,'Distance and location','According to Singer, why can\'t facts about location and the number of other potential rescuers matter morally? In what ways can they matter? How do the ways in which they can matter affect what we are required to do on his view? Make sure you explain his reasoning and give examples.','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table students
# ------------------------------------------------------------

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `student_identifier` int(10) unsigned DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_user_id_student_identifier_unique` (`user_id`,`student_identifier`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;

INSERT INTO `students` (`id`, `user_id`, `student_identifier`, `last_name`, `first_name`, `email`, `created_at`, `updated_at`)
VALUES
	(1,1,11111111,'Hobbes','Tommy','tommy@hobbes.com','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,1,22222222,'Hypatia','Ms','old@old.com','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,1,33333333,'Hume','Davey','davey@hume.edu','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,1,44444444,'Anscombe','Liz','liz@csun.edu','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'scratchUser1','test@gradeomatic.net','$2y$10$jZ3sBp7dKlEcFcBghPXk6eDHebWNbkfR3uhHV7SB/M4z/Kn.NI7XC',NULL,'2015-08-03 15:21:57','2015-08-03 15:21:57');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Dumping routines (PROCEDURE) for database 'gom_lar'
--
DELIMITER ;;

# Dump of PROCEDURE assign_element
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `assign_element` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`testuser4`@`localhost`*/ /*!50003 PROCEDURE `assign_element`(IN questionAssignmentId INT, IN subtask INT, IN elementId INT)
BEGIN
        INSERT INTO element_assignments (question_assignment_id, subtask, element_id)
        VALUES (questionAssignmentId, subtask, elementId) ON DUPLICATE KEY UPDATE element_id = elementId;

        SELECT question_assignment_id, subtask, element_id FROM element_assignments
        WHERE question_assignment_id = questionAssignmentId AND subtask = subtask AND element_id = elementId;
    END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE assign_question
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `assign_question` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`testuser4`@`localhost`*/ /*!50003 PROCEDURE `assign_question`(IN questionId INT, IN examId INT, IN questionNumber INT)
BEGIN
    INSERT INTO question_assignments (question_id, exam_id, question_number)
    VALUES (questionId, examId, questionNumber)
    ON DUPLICATE KEY UPDATE question_id = questionId;
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE question_score_averages_for_exam
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `question_score_averages_for_exam` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`testuser4`@`localhost`*/ /*!50003 PROCEDURE `question_score_averages_for_exam`(IN examId INT)
BEGIN
    SELECT qa.question_number AS questionNumber, q.questionName AS questionName, AVG(qs.score) AS average FROM question_scores qs
    INNER JOIN question_assignments qa ON qs.question_assignment_id = qa.id
    INNER JOIN questions q ON qa.question_id = q.id
    WHERE qa.exam_id = examId
    GROUP BY qs.question_assignment_id;
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE record_element_score
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `record_element_score` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`testuser4`@`localhost`*/ /*!50003 PROCEDURE `record_element_score`(IN elementAssignmentId INT, IN studentId INT, IN score FLOAT)
BEGIN
    INSERT INTO element_scores (element_assignment_id, student_id, score)
    VALUES (elementAssignmentId, studentId, score)
    ON DUPLICATE KEY UPDATE score = score;
  END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE record_question_score
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `record_question_score` */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`testuser4`@`localhost`*/ /*!50003 PROCEDURE `record_question_score`(IN questionAssignmentId INT, IN studentId INT, IN score FLOAT)
BEGIN
  INSERT INTO question_scores (question_assignment_id, student_id, score)
  VALUES (questionAssignmentId, studentId, score)
  ON DUPLICATE KEY UPDATE score = score;
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
