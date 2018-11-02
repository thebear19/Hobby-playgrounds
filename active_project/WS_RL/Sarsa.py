import gym
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
            return np.random.choice([a for a, q in enumerate(self.Q[state,:]) if q == np.max(self.Q[state,:])])
    
    def learn(self, state, action, reward, nextState, nextAction):
        self.Q[state, action] += self.ALPHA * (reward + self.GAMMA * self.Q[nextState, nextAction] - self.Q[state, action])

    def reduceExploration(self, i):
            self.EPSILON /= i+1

if __name__ == "__main__":
    env = gym.make('CliffWalking-v0')

    num_episodes = 200

    agent = SarsaAgent(env.nS, env.nA)

    total_reward = np.zeros(num_episodes)

    for i in range(num_episodes):
        state = env.reset()

        action = agent.chooseAction(state)
        
        while True:
            #env.render()

            nextState, reward, isDone, info = env.step(action)

            nextAction = agent.chooseAction(nextState)

            agent.learn(state, action, reward, nextState, nextAction)
            
            total_reward[i] += reward
            state = nextState
            action = nextAction
            
            if isDone == True:
                #agent.reduceExploration(i)
                break

    env.render()
    #print (agent.Q)

    #show graph
    '''x = np.arange(0, num_episodes, 1)
    y = np.array(total_reward)
    plt.plot(x, y)

    plt.xlabel('Episodes')
    plt.ylabel('Sum of rewards during episode')
    plt.title('The cliff walking task via Sarsa')
    plt.grid(True)
    plt.show()'''