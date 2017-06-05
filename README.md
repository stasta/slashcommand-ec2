# slashcommand-ec2

Helper to bootstrap Slash Commands to operate with AWS.
Created with Docker/php7 and AWS PHP SDK.

Images ready on References [1].

# Setup

1. Create your VPC with cfn/vpc.yaml.
2. Create your ECS stack wth cfn/ecs-cloudformation.yaml. Input your SlackToken as informed on your Slack Integration Settings.
3. Go to the Clouformation Outputs tab and copy your ECSALB endpoint and paste it on your Slash Command Integrations Settings page. Remember to include "http://" and the "/slack-command.php" path.
4. Save your Slash Command Integrations Settings and test it on slack with `/ec2search <EC2 Name>`


# References
1. https://hub.docker.com/r/stasta/slackcommand-ec2search
2. https://github.com/awslabs/ecs-refarch-cloudformation/blob/master/infrastructure/vpc.yaml
3. http://docs.aws.amazon.com/AWSCloudFormation/latest/UserGuide/quickref-ecs.html
