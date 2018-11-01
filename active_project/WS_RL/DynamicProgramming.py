import gym
import numpy as np
import matplotlib.pyplot as plt

class DPAgent:
    def __init__(self, model, state_size, action_size):
        self.GAMMA = .99
        self.EPSILON = 1e-4
        self.max_iterations = 200000

        self.num_action = action_size
        self.num_state = state_size
        self.model = model
    
    def policyEvaluation(self, V, policy):
        while True:
            delta = 0
            
            for state in range(self.num_state - 1):
                oldV = np.copy(V)
                
                [ (probability, nextState, reward, done) ]  = self.model[state][policy[state]]
                V[state] = probability * ( reward + self.GAMMA * V[nextState] )

                delta = np.maximum(delta, np.sum(np.abs(oldV - V)))

            if(delta < self.EPSILON):
                break
                  
        return V

    def policyImprovement(self, V):
        policy = np.zeros(self.num_state)
        
        for state in range(self.num_state):
            actions = np.zeros(self.num_action)

            for action in range(self.num_action):
                [ (probability, nextState, reward, done) ]  = self.model[state][action]
                
                actions[action] = probability * ( reward + self.GAMMA * V[nextState] )

            policy[state] = np.argmax(actions)

        return policy

    def policyIteration(self):
        V = np.zeros(self.num_state)
        policy = np.zeros(self.num_state)

        for i in range(self.max_iterations):
            V = self.policyEvaluation(V, policy)
            
            newPolicy = self.policyImprovement(V)
            
            isChange = (newPolicy != policy).sum()
            policy = newPolicy
            
            if isChange == 0:
                print ('Policy-Iteration converged at step %d.' %(i+1))
                break

        return policy
            

if __name__ == "__main__":
    env = gym.make('CliffWalking-v0')
    agent = DPAgent(env.P, env.nS, env.nA)
    
    policy = agent.policyIteration()
    print (policy)

    state = env.reset()
    
    while True:
        env.render()
        
        nextState, reward, isDone, info = env.step(policy[state])

        if isDone == True:
            break

        state = nextState

    env.render()