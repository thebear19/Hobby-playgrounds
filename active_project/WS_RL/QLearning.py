import numpy as np
import matplotlib.pyplot as plt

class QAgent:
    def __init__(self, state_size, action_size):
        self.EPSILON = .1
        self.ALPHA = .85
        self.GAMMA = .99
        self.num_action = action_size
        self.Q = np.zeros([state_size, self.num_action])

    def chooseAction(self, state):
        if np.random.binomial(1, self.EPSILON) == 1:
            return np.random.choice(self.num_action)
        else:
            return np.argmax(self.Q[state,:])
    
    def learn(self, state, action, reward, nextState):
        self.Q[state, action] += self.ALPHA*(reward + self.GAMMA*np.max(self.Q[nextState,:]) - self.Q[state, action])

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

        self.env = np.array(range(self.observation_space), dtype='U16').reshape(self.hight, self.width)
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
        print (self.env)


if __name__ == "__main__":
    env = CliffWalking(4, 12)

    num_episodes = 200
    num_steps = 100

    agent = QAgent(env.observation_space, env.action_space_n)

    total_reward = np.zeros(num_episodes)

    for i in range(num_episodes):
        state = env.reset()
        
        for j in range(num_steps):
            env.render()

            action = agent.chooseAction(state)
            
            nextState, reward, isDone, info = env.step(action)

            agent.learn(state, action, reward, nextState)
            
            total_reward[i] += reward
            state = nextState
            
            if isDone == True:
                agent.reduceExploration(i)
                break

    print (agent.Q)

    #show graph
    '''x = np.arange(0, num_episodes, 1)
    y = np.array(total_reward)
    plt.plot(x, y)

    plt.xlabel('Episodes')
    plt.ylabel('Sum of rewards during episode')
    plt.title('The cliff walking task via Q-learning')
    plt.grid(True)
    plt.show()'''