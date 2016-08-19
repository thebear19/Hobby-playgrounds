package org;
import java.awt.*;
import javax.swing.*;
public class GamePiece
{
	private final int Black=18,White=17,Space=16;
	private JLabel[] c;
	private Score score;
	
	// Create Piece
	public GamePiece(JPanel[][] gameBoard)
	{
		score = new Score();
		c = new JLabel[16];
		for(int x=0,i=0;x<gameBoard.length;x++)
		{
			for(int y=0;y<gameBoard[x].length;y++)
			{
				if((x+y)%2==0 && x<2)
				{
					c[i]= new JLabel(new ImageIcon("src/org/Image/W.gif"));
					c[i].setName(String.valueOf(i));
					gameBoard[y][x].add(c[i]);
					gameBoard[y][x].setName(String.valueOf(White));
					i++;
				}
				else if((x+y)%2==0 && x>5)
				{
					c[i]= new JLabel(new ImageIcon("src/org/Image/B.gif"));
					c[i].setName(String.valueOf(i));
					gameBoard[y][x].add(c[i]);
					gameBoard[y][x].setName(String.valueOf(Black));
					i++;
				}
			}
		}
	}
	public void nextMoveW(int PosX,int PosY,int APosX,int APosY,JPanel[][] gameBoard,int i,JLabel scoreW)
	{
		re(PosX,PosY,APosX,APosY,gameBoard);
		gameBoard[APosX][APosY].setBackground(Color.WHITE);
		gameBoard[APosX][APosY].setName(String.valueOf(Space));
		c[i]= new JLabel(new ImageIcon("src/org/Image/W.gif"));
		c[i].setName(String.valueOf(i));
		gameBoard[PosX][PosY].add(c[i]);
		gameBoard[PosX][PosY].setName(String.valueOf(White));
		gameBoard[PosX][PosY].validate();
		score.ScoreW(PosY,i);
		scoreW.setText("White score = "+score.getsW());
	}
	public void nextMoveB(int PosX,int PosY,int APosX,int APosY,JPanel[][] gameBoard,int i,JLabel scoreB)
	{
		re(PosX,PosY,APosX,APosY,gameBoard);
		gameBoard[APosX][APosY].setBackground(Color.WHITE);
		gameBoard[APosX][APosY].setName(String.valueOf(Space));
		c[i]= new JLabel(new ImageIcon("src/org/Image/B.gif"));
		c[i].setName(String.valueOf(i));
		gameBoard[PosX][PosY].add(c[i]);
		gameBoard[PosX][PosY].setName(String.valueOf(Black));
		gameBoard[PosX][PosY].validate();
		score.ScoreB(PosY,i);
		scoreB.setText("Black score = "+score.getsB());
	}
	public JLabel[] getC()
	{
		return c;
	}
	public void setC(JLabel[] c)
	{
		this.c = c;
	}
	public void re(int PosX,int PosY,int APosX,int APosY,JPanel[][] gameBoard)
	{
		gameBoard[PosX][PosY].removeAll();
		gameBoard[APosX][APosY].removeAll();
	}
	public void resetGame(JPanel[][] gameBoard)
	{
		for(int x=0,i=0;x<gameBoard.length;x++)
			for(int y=0;y<gameBoard[x].length;y++){
				gameBoard[y][x].removeAll();
				gameBoard[y][x].setName(String.valueOf(Space));
				if((x+y)%2==0 && x<2)
				{
					c[i]= new JLabel(new ImageIcon("src/org/Image/W.gif"));
					c[i].setName(String.valueOf(i));
					gameBoard[y][x].add(c[i]);
					gameBoard[y][x].setName(String.valueOf(White));
					i++;
				}
				else if((x+y)%2==0 && x>5)
				{
					c[i]= new JLabel(new ImageIcon("src/org/Image/B.gif"));
					c[i].setName(String.valueOf(i));
					gameBoard[y][x].add(c[i]);
					gameBoard[y][x].setName(String.valueOf(Black));
					i++;
				}
				score = new Score();
				gameBoard[y][x].validate();
			}
	}
}