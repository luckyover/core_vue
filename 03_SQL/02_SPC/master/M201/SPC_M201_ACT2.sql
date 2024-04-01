IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M201_ACT2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M201_ACT2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
--
--****************************************************************************************
--* 											
--*  処理概要/process overview	:	Delete a product size price
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuanLH - ANS902
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M201_ACT2
	@P_sizes_prices					NVARCHAR(MAX)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
	-- variable general
        @w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Delete'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N''

	-- INIT TEMPORARY TABLES
	CREATE TABLE #TMP_SIZES_PRICE_DELETE (
		item_cd						NVARCHAR(30)
    ,	color_cd					NVARCHAR(10)
    ,	size_cd						NVARCHAR(10)
    ,	price_list					SMALLINT
    ,	retail_upr					MONEY
    )
	-- END INIT TEMPORARY TABLES

	-- INSERT DATA @P_delete_sizes_price (TYPE: JSON) TO  #TMP_SIZES_PRICE_DELETE
	INSERT INTO #TMP_SIZES_PRICE_DELETE
    SELECT
        ISNULL(item_cd, SPACE(0))
    ,	ISNULL(color_cd, SPACE(0))
    ,	ISNULL(size_cd, SPACE(0))
    ,   ISNULL(price_list, 0)
    ,   CONVERT(MONEY, ISNULL(retail_upr, 0))  AS retail_upr
    FROM OPENJSON (@P_sizes_prices)
        WITH (
                item_cd						NVARCHAR(30)
    ,			color_cd					NVARCHAR(10)
	,			size_cd						NVARCHAR(10)
    ,			price_list					SMALLINT
    ,			retail_upr					MONEY
        ) AS TMP

    -- START TRANSACTION
    BEGIN TRANSACTION
    -- TRY CATCH EXCEPTION
    BEGIN TRY
		-- DELETE TABLE SIZES PRICE
        UPDATE M201 SET
					del_user_cd				 = @P_act_user_cd
        ,			del_prg					 = @P_prg
        ,			del_ip					 = @P_ip
        ,			del_tm					 = @w_time
        ,			del_flg					 = 1
        FROM M201
        INNER JOIN #TMP_SIZES_PRICE_DELETE AS tmp_delete		ON (
			M201.item_cd					 =  tmp_delete.item_cd
		AND	M201.color_cd					 =  tmp_delete.color_cd
		AND M201.size_cd					 =  tmp_delete.size_cd
		AND M201.price_list					 =  tmp_delete.price_list
		AND M201.retail_upr					 =  tmp_delete.retail_upr		
        )

    END TRY
    BEGIN CATCH
        SET @w_prs_result	=   N'NG'
        SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
                                N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
                                N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
                                N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT
                 N'E009'
        ,		 N''
        ,        0
        ,        999
        ,        0
        ,	     N''
        ,   @w_remarks
    END CATCH

    IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
        IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
    END
    ELSE
        BEGIN
            DELETE FROM @ERR_TBL
            IF(@@TRANCOUNT > 0)
            BEGIN
                COMMIT TRANSACTION
        END
    END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

    SELECT * FROM @ERR_TBL

    DROP TABLE IF EXISTS #TMP_SIZES_PRICE_INSERT
    DROP TABLE IF EXISTS #TMP_SIZES_PRICE_DELETE
    DROP TABLE IF EXISTS #TMP_SIZES_PRICE_UPDATE
END

