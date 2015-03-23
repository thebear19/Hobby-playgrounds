package org;
import java.awt.*;
import javax.swing.*;

import java.awt.event.*;
public class BoardGame extends JFrame implements MouseListener
{
	private final int x=70,y=70,width=70,height=70;
	private final String Black="18",White="17",Space="16";
	private JPanel[][] gameBoard;
	private JLabel ScoreW,ScoreB;
	private int state=1,APosX,APosY,iW,iB,player=0,cheakR=0,cheakL=0,ck=0,combo=0;
	private GamePiece piece;
	private Score s = new Score();
	
	public BoardGame()
	{
		// Main Display
		setTitle("Mak Kham");
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		setSize(800,600);
		setResizable(false);
		setLocationRelativeTo(null);
		getContentPane().setLayout(null);
		
		// Create MenuBar
		JMenuBar menuBar = new JMenuBar();
		setJMenuBar(menuBar);
				
		// MenuFile
		JMenu File = new JMenu("File");
		menuBar.add(File);
				
		// IconExit
		JMenuItem Exit = new JMenuItem("Exit");
		Exit.addActionListener(new ActionListener()
		{
			public void actionPerformed(ActionEvent arg0)
			{
				System.exit(0);
			}
		});
		
		// IconNewGame 
		JMenuItem NewGame = new JMenuItem("New Game");
		NewGame.addActionListener(new ActionListener()
		{
			public void actionPerformed(ActionEvent arg0)
			{
				player = 0;
				ck = 0;
				piece.resetGame(gameBoard);
				s.setsW(0);
				s.setsB(0);
				s.reI();
				ScoreW.setText("White score = "+s.getsW());
				ScoreB.setText("Black score = "+s.getsB());
				JOptionPane.showMessageDialog(null,"Press Start");
			}
		});
		File.add(NewGame);
		File.add(Exit);
		Board();
	}
	public void Board()
	{
		// Score Display
		JPanel scoreBoard = new JPanel();
		scoreBoard.setBounds(561,0,237,551);
		scoreBoard.setBackground(Color.DARK_GRAY);
		getContentPane().add(scoreBoard);
		
		// Score Image
		JLabel PicW = new JLabel(new ImageIcon("src/org/Image/W.gif"));
		PicW.setBounds(24,88,38,51);
		JLabel PicB = new JLabel(new ImageIcon("src/org/Image/B.gif"));
		PicB.setBounds(24,188,38,51);
		
		// Score Counter
		ScoreW = new JLabel("White score = "+s.getsW());
		ScoreW.setBounds(80,105,147,14);
		ScoreW.setForeground(Color.PINK);
		ScoreB = new JLabel("Black score = "+s.getsB());
		ScoreB.setBounds(80,205,147,14);
		ScoreB.setForeground(Color.MAGENTA);
		
		// Start Button
		JButton StartGame = new JButton("Start");
		StartGame.setBounds(80,410,72,58);
		StartGame.addActionListener(new ActionListener()
		{
			public void actionPerformed(ActionEvent arg0)
			{
				if(ck==0)
				{
					Object[] options ={"White","Black"};
					player = JOptionPane.showOptionDialog(null,"What is color of first player ?","First Player",JOptionPane.YES_NO_OPTION,JOptionPane.QUESTION_MESSAGE,null,options,options[0]);
					if(player==0)
						player = 1;
					else
						player = 2;
					ck = 1;
				}
			}
		});
		
		scoreBoard.setLayout(null);
		scoreBoard.add(PicW);
		scoreBoard.add(PicB);
		scoreBoard.add(ScoreW);
		scoreBoard.add(ScoreB);
		scoreBoard.add(StartGame);
		
		// Create GameTable Display
		gameBoard = new JPanel[8][8];
		for(int y=0;y<gameBoard.length;y++)
		{
			for(int x=0;x<gameBoard[y].length;x++)
			{
				gameBoard[y][x] = new JPanel();
				if((x+y)%2==0)
					gameBoard[y][x].setBackground(Color.WHITE);
				else
					gameBoard[y][x].setBackground(Color.BLACK);
				gameBoard[y][x].setBounds(this.x*y, this.y*x, width, height);
				gameBoard[y][x].setLayout(new BorderLayout());
				gameBoard[y][x].setName("16");
				getContentPane().add(gameBoard[y][x]);
			}
		}
		getContentPane().addMouseListener((MouseListener) this);
		piece = new GamePiece(gameBoard);
	}
	public void CheakW(int cheakR,int cheakL,int PosX,int PosY)
	{
		if((cheakR==1)||(cheakL==1))
		{
			this.cheakR = 0;
			this.cheakL = 0;
			state = 2;
			combo = 1;
			APosX = PosX;
			APosY = PosY;
			gameBoard[PosX][PosY].setBackground(Color.RED);
		}
		else
		{
			this.cheakR = 0;
			this.cheakL = 0;
			combo = 0;
			state = 1;
			player = 2;
		}
	}
	public void CheakB(int cheakR,int cheakL,int PosX,int PosY)
	{
		if(cheakR==1||cheakL==1)
		{
			this.cheakR = 0;
			this.cheakL = 0;
			state = 2;
			combo = 1;
			APosX = PosX;
			APosY = PosY;
			gameBoard[PosX][PosY].setBackground(Color.RED);
		}
		else
		{
			this.cheakR = 0;
			this.cheakL = 0;
			combo = 0;
			state = 1;
			player = 1;
		}
	}
	public void mouseClicked(MouseEvent e)
	{
		int X = e.getX();
		int Y = e.getY();
		int PosX = X /width;
		int PosY = Y /height;
		
		// User1 Target
		if(state==1 && player==1 && (gameBoard[PosX][PosY].getName()).equals(White))
		{
			iW = Integer.parseInt((gameBoard[PosX][PosY].getComponent(0)).getName());
			if((gameBoard[PosX][PosY].getComponent(0)).equals(piece.getC()[iW]))
			{
				APosX = PosX;
				APosY = PosY;
				gameBoard[PosX][PosY].setBackground(Color.RED);
				state=2;
			}
		}
		// Target Move&Cancel
		else if(state==2 && player==1)
		{
			if((gameBoard[PosX][PosY].getBackground()).equals(Color.WHITE))
			{
				if((PosY-APosY)==2 && Math.abs(PosX-APosX)==2)
				{
					if((gameBoard[PosX][PosY].getName()).equals(Space))
					{
						if(!(gameBoard[Math.abs(PosX-1)][Math.abs(PosY-1)].getName()).equals(Space))
						{
							piece.nextMoveW(PosX,PosY,APosX,APosY,gameBoard,iW,ScoreW);
							if(PosX>1 && PosY<6)
							{
								if(!(gameBoard[Math.abs(PosX-1)][PosY+1].getName()).equals(Space))
								{
									if((gameBoard[Math.abs(PosX-2)][PosY+2].getName()).equals(Space))
										cheakL = 1;
									else
										cheakL = 2;
								}
								else
									cheakL = 2;
							}
							else
								cheakL = 2;
							if(PosX<6 && PosY<6)
							{
								if(!(gameBoard[PosX+1][PosY+1].getName()).equals(Space))
								{
									if((gameBoard[PosX+2][PosY+2].getName()).equals(Space))
										cheakR = 1;
									else
										cheakR = 2;
								}
								else
									cheakR = 2;
							}
							else
								cheakR = 2;
							CheakW(cheakR,cheakL,PosX,PosY);
						}
						else if(!(gameBoard[PosX+1][Math.abs(PosY-1)].getName()).equals(Space))
						{
							piece.nextMoveW(PosX,PosY,APosX,APosY,gameBoard,iW,ScoreW);
							if(PosX>1 && PosY<6)
							{
								if(!(gameBoard[Math.abs(PosX-1)][PosY+1].getName()).equals(Space))
								{
									if((gameBoard[Math.abs(PosX-2)][PosY+2].getName()).equals(Space))
										cheakL = 1;
									else
										cheakL = 2;
								}
								else
									cheakL = 2;
							}
							else
								cheakL = 2;
							if(PosX<6 && PosY<6)
							{
								if(!(gameBoard[PosX+1][PosY+1].getName()).equals(Space))
								{
									if((gameBoard[PosX+2][PosY+2].getName()).equals(Space))
										cheakR = 1;
									else
										cheakR = 2;
								}
								else
									cheakR = 2;
							}
							else
								cheakR = 2;
							CheakW(cheakR,cheakL,PosX,PosY);
						}
					}
				}
				else if((PosY-APosY)==1 && Math.abs(PosX-APosX)==1 && combo!=1)
				{
					if((gameBoard[PosX][PosY].getName()).equals(Space))
					{
						piece.nextMoveW(PosX,PosY,APosX,APosY,gameBoard,iW,ScoreW);
						state=1;
						player=2;
					}
				}
			}
			else if((gameBoard[PosX][PosY].getBackground()).equals(Color.RED) && combo!=1)
			{
				gameBoard[APosX][APosY].setBackground(Color.WHITE);
				state=1;
			}
		}
		// User2 Target
		else if(state==1 && player==2 && (gameBoard[PosX][PosY].getName()).equals(Black))
		{
			iB = Integer.parseInt((gameBoard[PosX][PosY].getComponent(0)).getName());
			if((gameBoard[PosX][PosY].getComponent(0)).equals(piece.getC()[iB]))
			{
				APosX = PosX;
				APosY = PosY;
				gameBoard[PosX][PosY].setBackground(Color.RED);
				state=2;
			}
		}
		// Target Move&Cancel
		else if(state==2 && player==2)
		{
			if((gameBoard[PosX][PosY].getBackground()).equals(Color.WHITE))
			{
				if((APosY-PosY)==2 && Math.abs(APosX-PosX)==2)
				{
					if((gameBoard[PosX][PosY].getName()).equals(Space))
					{
						if(!(gameBoard[Math.abs(PosX-1)][PosY+1].getName()).equals(Space))
						{
							piece.nextMoveB(PosX,PosY,APosX,APosY,gameBoard,iB,ScoreB);
							if(PosX>1 && PosY>1)
							{
								if(!(gameBoard[Math.abs(PosX-1)][Math.abs(PosY-1)].getName()).equals(Space))
								{
									if((gameBoard[Math.abs(PosX-2)][Math.abs(PosY-2)].getName()).equals(Space))
										cheakL = 1;
									else
										cheakL = 2;
								}
								else
									cheakL = 2;
							}
							else
								cheakL = 2;
							if(PosX<6 && PosY>1)
							{
								if(!(gameBoard[PosX+1][Math.abs(PosY-1)].getName()).equals(Space))
								{
									if((gameBoard[PosX+2][Math.abs(PosY-2)].getName()).equals(Space))
										cheakR = 1;
									else
										cheakR = 2;
								}
								else
									cheakR = 2;
							}
							else
								cheakR = 2;
							CheakB(cheakR,cheakL,PosX,PosY);
						}
						else if(!(gameBoard[PosX+1][PosY+1].getName()).equals(Space))
						{
							piece.nextMoveB(PosX,PosY,APosX,APosY,gameBoard,iB,ScoreB);
							if(PosX>1 && PosY>1)
							{
								if(!(gameBoard[Math.abs(PosX-1)][Math.abs(PosY-1)].getName()).equals(Space))
								{
									if((gameBoard[Math.abs(PosX-2)][Math.abs(PosY-2)].getName()).equals(Space))
										cheakL = 1;
									else
										cheakL = 2;
								}
								else
									cheakL = 2;
							}
							else
								cheakL = 2;
							if(PosX<6 && PosY>1)
							{
								if(!(gameBoard[PosX+1][Math.abs(PosY-1)].getName()).equals(Space))
								{
									if((gameBoard[PosX+2][Math.abs(PosY-2)].getName()).equals(Space))
										cheakR = 1;
									else
										cheakR = 2;
								}
								else
									cheakR = 2;
							}
							else
								cheakR = 2;
							CheakB(cheakR,cheakL,PosX,PosY);
						}
					}
				}
				else if((APosY-PosY)==1 && Math.abs(APosX-PosX)==1 && combo!=1)
				{
					if((gameBoard[PosX][PosY].getName()).equals(Space))
					{
						piece.nextMoveB(PosX,PosY,APosX,APosY,gameBoard,iB,ScoreB);
						state=1;
						player=1;
					}
				}
			}
			else if((gameBoard[PosX][PosY].getBackground()).equals(Color.RED) && combo!=1)
			{
				gameBoard[APosX][APosY].setBackground(Color.WHITE);
				state=1;
			}
		}
	}
	public void mouseEntered(MouseEvent e)
	{
	}
	public void mouseExited(MouseEvent e)
	{
	}
	public void mousePressed(MouseEvent e)
	{
	}
	public void mouseReleased(MouseEvent e)
	{
	}
}