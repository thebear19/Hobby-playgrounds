import numpy as np
import matplotlib.pyplot as plt

class SarsaAgent:
    def __init__(self, state_size, action_size):
        self.EPSILON = .1
        self.ALPHA = .15
        self.GAMMA = .95
        self.num_action = action_size
        self.Q = np.zeros([state_size, self.num_action])

    def chooseAction(self, state):
        if np.random.binomial(1, self.EPSILON) == 1:
            return np.random.choice(self.num_action)
        else:
            return np.random.choice([i for i, val in enumerate(self.Q[state,:]) if val == np.max(self.Q[state,:])])
    
    def learn(self, state, action, reward, nextState, nextAction):
        self.Q[state, action] += self.ALPHA*(reward + self.GAMMA*self.Q[nextState, nextAction] - self.Q[state, action])

    def reduceExploration(self, i):
            self.EPSILON /= i+1


class  CliffWalking:
    def __init__(self, hight, width):
        self.hight = hight
        self.width = width
        self.observation_space = self.hight * self.width
        self.action_space = [ "U", "D", "L", "R" ]
        self.action_space_n = len(self.action_space)

        self.current_position = [ self.hight-1, 0 ]

        self.env = np.array(range(self.observation_space), dtype='a16').reshape(self.hight, self.width)
        self.mapper = np.array(range(self.observation_space)).reshape(self.hight, self.width)
        self.env[ :, : ] = " "
        self.env[ self.hight-1, 1:self.width-1 ] = "X"
        self.env[ self.hight-1, 0 ] = "*"
        self.env[ self.hight-1, self.width-1 ] = "G"

    def step(self, action):
        #remove previous_position
        self.env[ self.current_position[ 0 ], self.current_position[ 1 ] ] = " "

        #calculate next_position
        if (self.action_space[ action ] == self.action_space[ 0 ] and self.current_position[ 0 ] > 0):
            self.current_position[ 0 ] += -1
        elif (self.action_space[ action ] == self.action_space[ 1 ] and self.current_position[ 0 ] < self.hight-1):
            self.current_position[ 0 ] += 1
        elif (self.action_space[ action ] == self.action_space[ 2 ] and self.current_position[ 1 ] > 0):
            self.current_position[ 1 ] += -1
        elif (self.action_space[ action ] == self.action_space[ 3 ] and self.current_position[ 1 ] < self.width-1):
            self.current_position[ 1 ] += 1

        nextState = self.mapper[ self.current_position[ 0 ], self.current_position[ 1 ] ]

        #receive reward
        reward = -100 if (self.env[ self.current_position[ 0 ], self.current_position[ 1 ] ] == "X") else -1

        #check is the game over
        isDone = True if (self.env[ self.current_position[ 0 ], self.current_position[ 1 ] ] == "X" or self.env[ self.current_position[ 0 ], self.current_position[ 1 ] ] == "G") else False

        #render next_position
        if (not isDone):
            self.env[ self.current_position[ 0 ], self.current_position[ 1 ] ] = "*"
        
        return nextState, reward, isDone, ""
    
    def reset(self):
        self.env[ self.hight-1, 0 ] = "*"
        self.current_position = [ self.hight-1, 0 ]
        
        return self.mapper[ self.hight-1, 0 ]

    def render(self):
        print self.env


if __name__ == "__main__":
    env = CliffWalking(4, 12)

    num_episodes = 1000
    num_steps = 150

    agent = SarsaAgent(env.observation_space, env.action_space_n)

    total_reward = np.zeros(num_episodes)

    for i in range(num_episodes):
        state = env.reset()

        action = agent.chooseAction(state)
        
        for j in range(num_steps):
            env.render()

            nextState, reward, isDone, info = env.step(action)

            nextAction = agent.chooseAction(nextState)

            agent.learn(state, action, reward, nextState, nextAction)
            
            total_reward[i] += reward
            state = nextState
            action = nextAction
            
            if isDone == True:
                #agent.reduceExploration(i)
                break

    print agent.Q

    '''#show graph
    x = np.arange(0, num_episodes, 1)
    y = np.array(total_reward)
    plt.plot(x, y)

    plt.xlabel('Episodes')
    plt.ylabel('Sum of rewards during episode')
    plt.title('The cliff walking task via Sarsa')
    plt.grid(True)
    plt.show()'''